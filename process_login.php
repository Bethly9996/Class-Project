<?php
// Define your database connection details
$host = 'localhost';
$username = 'your_database_username';
$password = '';
$database = 'voters';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the input values from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare a SQL query to check if the voter's credentials are valid
$sql = "SELECT * FROM voters WHERE username='$username' AND password='$password'";

// Execute the query
$result = $conn->query($sql);

// Check if the query returned a row
if ($result->num_rows > 0) {
    // The voter's credentials are valid - redirect them to the voting page
    header('Location: voting_page.php');
    exit();
} else {
    // The voter's credentials are not valid - display an error message
    echo "Invalid username or password.";
}

// Close the database connection
$conn->close();
?>
