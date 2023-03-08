<!DOCTYPE html>
<html>
<head>
	<title>Voting Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1>Welcome to the Election</h1>
	<p>Please select your preferred candidate from the list below:</p>

	<?php
	// Define your database connection details
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'voters';

	// Create a connection to the database
	$conn = new mysqli($host, $username, $password, $database);

	// Check if the connection was successful
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	// Retrieve the list of candidates from the database
	$sql = "SELECT * FROM candidates";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// Display the list of candidates
		while($row = $result->fetch_assoc()) {
			echo "<div class='candidate'>";
			echo "<img src='" . $row['photo'] . "' alt='" . $row['name'] . "'>";
			echo "<h2>" . $row['name'] . "</h2>";
			echo "<p>Party: " . $row['party'] . "</p>";
			echo "<p>" . $row['description'] . "</p>";
			echo "<form method='post'>";
			echo "<input type='hidden' name='candidate_id' value='" . $row['id'] . "'>";
			echo "<input type='submit' value='Vote'>";
			echo "</form>";
			echo "</div>";
		}
	} else {
		echo "No candidates found.";
	}

	// Check if the form has been submitted
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Get the candidate ID from the form
		$candidate_id = $_POST['candidate_id'];

		// Prepare a SQL query to insert the vote into the database
		$sql = "INSERT INTO votes (candidate_id) VALUES ($candidate_id)";

		// Execute the query
		if ($conn->query($sql) === TRUE) {
			echo "<p>Thank you for voting!</p>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	// Close the database connection
	$conn->close();
	?>

</body>
</html>
