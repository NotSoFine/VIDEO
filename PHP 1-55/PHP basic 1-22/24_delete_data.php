<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'my_database';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Basic DELETE query
$sql = "DELETE FROM users WHERE username = 'john_doe'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully\n";
    echo "Affected rows: " . $conn->affected_rows . "\n";
} else {
    echo "Error deleting record: " . $conn->error . "\n";
}

// Prepared DELETE statement
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");

// Bind parameter
$user_id = 5;
$stmt->bind_param("i", $user_id);

// Execute the statement
if ($stmt->execute()) {
    echo "Record deleted successfully using prepared statement\n";
    echo "Affected rows: " . $stmt->affected_rows . "\n";
} else {
    echo "Error deleting record: " . $stmt->error . "\n";
}

// DELETE with multiple conditions
$sql = "DELETE FROM users 
        WHERE created_at < '2023-01-01' 
        AND (email LIKE '%@oldomain.com' 
        OR last_login IS NULL)";

if ($conn->query($sql) === TRUE) {
    echo "Deleted " . $conn->affected_rows . " inactive users\n";
} else {
    echo "Error deleting records: " . $conn->error . "\n";
}

// IMPORTANT: Always use WHERE clause
// This would delete ALL records - very dangerous!
// DELETE FROM users;

$stmt->close();
$conn->close();
?>