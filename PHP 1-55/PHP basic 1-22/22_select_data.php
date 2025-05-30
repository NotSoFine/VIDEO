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

// Basic SELECT query
echo "Basic SELECT query:\n";
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . 
             " - Username: " . $row["username"] . 
             " - Email: " . $row["email"] . "\n";
    }
} else {
    echo "0 results\n";
}

// Prepared SELECT statement with WHERE clause
echo "\nPrepared SELECT statement:\n";
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id > ?");
$min_id = 2;
$stmt->bind_param("i", $min_id);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "Username: " . $row["username"] . 
         " - Email: " . $row["email"] . "\n";
}

// Different ways to fetch results
echo "\nDifferent fetch methods:\n";
$sql = "SELECT * FROM users LIMIT 3";
$result = $conn->query($sql);

// fetch_assoc() - Returns associative array
$row = $result->fetch_assoc();
echo "fetch_assoc(): " . $row["username"] . "\n";

// fetch_array() - Returns array with both numeric and associative indices
$row = $result->fetch_array();
echo "fetch_array(): " . $row[0] . " - " . $row["username"] . "\n";

// fetch_object() - Returns object
$row = $result->fetch_object();
echo "fetch_object(): " . $row->username . "\n";

$stmt->close();
$conn->close();
?>