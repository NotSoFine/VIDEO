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

// Example 1: Basic SELECT with result binding
echo "Example 1: Basic SELECT with result binding\n";

$stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id > ?");
$min_id = 5;
$stmt->bind_param("i", $min_id);
$stmt->execute();

// Bind result variables
$id = null;
$username = null;
$email = null;
$stmt->bind_result($id, $username, $email);

// Fetch and display results
while ($stmt->fetch()) {
    echo "ID: $id, Username: $username, Email: $email\n";
}

// Example 2: Using get_result() method (if mysqlnd is available)
echo "\nExample 2: Using get_result()\n";

$stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ?");
$search = "%user%";
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "Username: " . $row['username'] . ", Email: " . $row['email'] . "\n";
}

// Example 3: Complex SELECT with multiple parameters
echo "\nExample 3: Complex SELECT\n";

$stmt = $conn->prepare("SELECT username, email 
                       FROM users 
                       WHERE created_at > ? 
                       AND (email LIKE ? OR username LIKE ?)");

$date = '2023-01-01';
$pattern = '%test%';
$stmt->bind_param("sss", $date, $pattern, $pattern);
$stmt->execute();

$stmt->bind_result($username, $email);
while ($stmt->fetch()) {
    echo "Username: $username, Email: $email\n";
}

// Benefits of Prepared Statements:
/*
1. Security:
   - Prevents SQL injection by automatically escaping special characters
   - Parameters are sent separately from the query

2. Performance:
   - Query is parsed and compiled only once
   - Can be executed multiple times with different parameters
   - Reduces server load for repeated queries

3. Code Quality:
   - Cleaner and more maintainable code
   - Clear separation between SQL and data
   - Reduces the chance of syntax errors

4. Type Safety:
   - Automatic type handling based on bind_param types
   - Helps prevent type-related errors
*/

$stmt->close();
$conn->close();
?>