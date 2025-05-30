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

// Example 1: INSERT with prepared statement
echo "Example 1: INSERT with prepared statement\n";

$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");

// Bind parameters
// i - integer
// d - double
// s - string
// b - blob
$username = "new_user";
$email = "new@example.com";
$password_hash = password_hash("password123", PASSWORD_DEFAULT);

$stmt->bind_param("sss", $username, $email, $password_hash);

if ($stmt->execute()) {
    echo "New record inserted successfully\n";
} else {
    echo "Error: " . $stmt->error . "\n";
}

// Example 2: UPDATE with prepared statement
echo "\nExample 2: UPDATE with prepared statement\n";

$stmt = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
$new_email = "updated@example.com";
$target_username = "new_user";

$stmt->bind_param("ss", $new_email, $target_username);

if ($stmt->execute()) {
    echo "Record updated successfully\n";
} else {
    echo "Error: " . $stmt->error . "\n";
}

// Example 3: Multiple executions
echo "\nExample 3: Multiple executions with same prepared statement\n";

$stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $email);

$users = [
    ['user1', 'user1@example.com'],
    ['user2', 'user2@example.com'],
    ['user3', 'user3@example.com']
];

foreach ($users as $user) {
    $username = $user[0];
    $email = $user[1];
    if ($stmt->execute()) {
        echo "Inserted user: $username\n";
    } else {
        echo "Error inserting user: $username\n";
    }
}

$stmt->close();
$conn->close();
?>