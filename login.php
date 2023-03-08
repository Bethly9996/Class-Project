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
	$voter_id = $_POST['voter_id'];
	$password = $_POST['password'];

	// Prepare a SQL query to check if the voter exists in the database
	$sql = "SELECT * FROM voters WHERE voter_id = '$voter_id' AND password = '$password'";

	// Execute the query
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// Voter was found - redirect to the voting page
		header('Location: voting.php');
		exit();
	} else {
		// Voter was not found - display an error message
		echo "Invalid Voter ID or password.";
	}
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Sign In</h1>

    <form method="post">
        <label for="voter_id">Voter ID:</label>
        <input type="text" name="voter_id" id="voter_id" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Sign In">
    </form>
</body>
</html>
