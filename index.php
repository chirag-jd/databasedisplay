<!DOCTYPE html>
<html>
<head>
	<title>Display Database Tables</title>
	<style>
		/* Style the tab */
		.tab {
			overflow: hidden;
			border: 1px solid #ccc;
			background-color: #f1f1f1;
		}
		
		/* Style the buttons inside the tab */
		.tab button {
			background-color: inherit;
			float: left;
			border: none;
			outline: none;
			cursor: pointer;
			padding: 14px 16px;
			transition: 0.3s;
			font-size: 17px;
		}
		
		/* Change background color of buttons on hover */
		.tab button:hover {
			background-color: #ddd;
		}
		
		/* Create an active/current tablink class */
		.tab button.active {
			background-color: #ccc;
		}
		
		/* Style the tab content */
		.tabcontent {
			display: none;
			padding: 6px 12px;
			border: 1px solid #ccc;
			border-top: none;
		}
	</style>
</head>
<body>
	<div class="tab">

		<?php
		// MySQLi connection
		$mysqli = new mysqli("localhost", "database username", "database password", "database name");

		// Check connection
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_error;
			exit();
		}

		// Get all table names in the database
		$tables = array();
		$result = $mysqli->query("SHOW TABLES");
		while ($row = $result->fetch_array(MYSQLI_NUM)) {
			$tables[] = $row[0];
		}

		// Loop through each table and display its name, column names, and data
		foreach ($tables as $table) {
			echo "<button class='tablinks' onclick='openTab(event, \"$table\")'>$table</button>";
		}
		?>

		<!-- Create tab content for each table -->
		<?php
		foreach ($tables as $table) {
			echo "<div id='$table' class='tabcontent'>";
			echo "<h2>Table: $table</h2>";
			echo "<table border='1'>";
			$result = $mysqli->query("SELECT * FROM $table");
			$fields = $result->fetch_fields();
			echo "<tr>";
			foreach ($fields as $field) {
				echo "<th>$field->name</th>";
			}
			echo "</tr>";
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				foreach ($row as $value) {
					echo "<td>$value</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			echo "</div>";
		}

		// Close MySQLi connection
		$mysqli->close();
		?>
	</div>

	<script>
		// Show default table
		document.getElementById("<?php echo $tables[0]; ?>").style.display = "block";



	// Function to open a specific tab content
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;

  // Hide all tab content
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove active class from all tab links
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the selected tab content and add active class to the selected tab link
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
</body>
</html>
