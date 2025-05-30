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

// Basic INSERT query
$sql = "INSERT INTO users (username, email, password_hash) 
        VALUES ('john_doe', 'john@example.com', 'hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully\n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error . "\n";
}

// Prepared statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");

// Bind parameters
$username = "jane_doe";
$email = "jane@example.com";
$password_hash = password_hash("secure_password", PASSWORD_DEFAULT);

$stmt->bind_param("sss", $username, $email, $password_hash);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully using prepared statement\n";
} else {
    echo "Error: " . $stmt->error . "\n";
}

// Insert multiple records
$users = [
    ['alice', 'alice@example.com', 'password1'],
    ['bob', 'bob@example.com', 'password2'],
    ['charlie', 'charlie@example.com', 'password3']
];

$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");

foreach ($users as $user) {
    $stmt->bind_param("sss", $user[0], $user[1], $user[2]);
    if ($stmt->execute()) {
        echo "Inserted user: " . $user[0] . "\n";
    } else {
        echo "Error inserting user: " . $user[0] . "\n";
    }
}

$stmt->close();
$conn->close();
?>