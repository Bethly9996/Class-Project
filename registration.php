<!DOCTYPE html>
<html>
<head>
	<title>Voter Registration</title>
	<link rel="stylesheet" type="text/css" href="stylereg.css">
</head>
<body>
	<h1>Voter Registration</h1>

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

	// Check if the form has been submitted
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Get the input values from the form
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$voter_id = $_POST['voter_id'];

		// Check if the voter ID is valid
		if (!preg_match('/^[0-9]{8}$/', $voter_id)) {
			echo "Error: Voter ID must be an 8-digit number.<br>";
			exit();
		}

		// Prepare a SQL query to insert the new voter into the database
		$sql = "INSERT INTO voters (username, password, email, voter_id) VALUES ('$username', '$password', '$email', '$voter_id')";

		// Execute the query
		if ($conn->query($sql) === TRUE) {
			// Registration was successful - redirect the voter to the sign-in page
			header('Location: login.php');
			exit();
		} else {
			// Registration failed - display an error message
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	// Close the database connection
	$conn->close();
	?>

	<form method="post">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" required>
        <label for="email">Email:</label>
		<input type="email" name="email" id="email" required>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required>
		<label for="voter_id">Voter ID:</label>
		<input type="text" name="voter_id" id="voter_id" required>
		<input type="submit" value="Register">
	</form>
</body>
</html>
