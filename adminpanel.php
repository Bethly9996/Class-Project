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

// Check if the user is logged in as an admin
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

// Check if the form to add a new voter has been submitted
if (isset($_POST['add_voter'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $voter_id = $_POST['voter_id'];

    // Prepare a SQL query to insert the new voter into the database
    $sql = "INSERT INTO voters (username, password, email, voter_id) VALUES ('$username', '$password', '$email', '$voter_id')";

    // Execute the query
    if ($conn->query($sql) !== TRUE) {
        // Registration failed - display an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if the form to add a new position has been submitted
if (isset($_POST['add_position'])) {
    $position_name = $_POST['position_name'];

    // Prepare a SQL query to insert the new position into the database
    $sql = "INSERT INTO positions (position_name) VALUES ('$position_name')";

    // Execute the query
    if ($conn->query($sql) !== TRUE) {
        // Adding position failed - display an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if the form to add a new candidate has been submitted
if (isset($_POST['add_candidate'])) {
    $candidate_name = $_POST['candidate_name'];
    $position_id = $_POST['position_id'];

    // Prepare a SQL query to insert the new candidate into the database
    $sql = "INSERT INTO candidates (candidate_name, position_id) VALUES ('$candidate_name', '$position_id')";

    // Execute the query
    if ($conn->query($sql) !== TRUE) {
        // Adding candidate failed - display an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Get the total number of votes
$sql = "SELECT COUNT(*) AS total_votes FROM votes";
$result = $conn->query($sql);
$total_votes = $result->fetch_assoc()['total_votes'];

// Get the list of voters
$sql = "SELECT * FROM voters";
$result = $conn->query($sql);
$voters = $result->fetch_all(MYSQLI_ASSOC);

// Get the list of positions
$sql = "SELECT * FROM positions";
$result = $conn->query($sql);
$positions = $result->fetch_all(MYSQLI_ASSOC);

// Get the list of candidates
$sql = "SELECT candidates.*, positions.position_name FROM candidates LEFT JOIN positions ON candidates.position_id = positions.id";
$result = $conn->query($sql);
$candidates = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="styleadmin.css">
</head>
<body>
	<h1>Admin Panel</h1>

	<h2>Total Votes</h2>
	<p>There have been 1000 total votes cast.</p>

	<h2>Add Voter</h2>
	<form method="post">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" required>

		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required>

		<label for="email">Email:</label>
		<input type="email" name="email" id="email" required>

		<input type="submit" value="Add Voter">
	</form>

	<h2>List Voters</h2>
	<table>
		<thead>
			<tr>
				<th>Username</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>JohnDoe</td>
				<td>john.doe@example.com</td>
			</tr>
			<tr>
				<td>JaneDoe</td>
				<td>jane.doe@example.com</td>
			</tr>
		</tbody>
	</table>

	<h2>Add Position</h2>
	<form method="post">
		<label for="position_name">Position Name:</label>
		<input type="text" name="position_name" id="position_name" required>

		<input type="submit" value="Add Position">
	</form>

	<h2>List Positions</h2>
	<ul>
		<li>President</li>
		<li>Vice President</li>
	</ul>

	<h2>Add Candidate</h2>
	<form method="post">
		<label for="candidate_name">Candidate Name:</label>
		<input type="text" name="candidate_name" id="candidate_name" required>

		<label for="position_id">Position:</label>
		<select name="position_id" id="position_id">
			<option value="1">President</option>
			<option value="2">Vice President</option>
		</select>

		<input type="submit" value="Add Candidate">
	</form>

	<h2>List Candidates</h2>
	<table>
		<thead>
			<tr>
				<th>Candidate Name</th>
				<th>Position</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>John Doe</td>
				<td>President</td>
			</tr>
			<tr>
				<td>Jane Doe</td>
				<td>Vice President</td>
			</tr>
		</tbody>
	</table>
</body>
</html>
