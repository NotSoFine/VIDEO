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

// Basic UPDATE query
$sql = "UPDATE users SET email = 'john.doe@example.com' WHERE username = 'john_doe'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully\n";
} else {
    echo "Error updating record: " . $conn->error . "\n";
}

// Prepared UPDATE statement
$stmt = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");

// Bind parameters
$new_email = "jane.doe@example.com";
$username = "jane_doe";

$stmt->bind_param("ss", $new_email, $username);

// Execute the statement
if ($stmt->execute()) {
    echo "Record updated successfully using prepared statement\n";
    echo "Affected rows: " . $stmt->affected_rows . "\n";
} else {
    echo "Error updating record: " . $stmt->error . "\n";
}

// Multiple updates with different conditions
echo "\nUpdating multiple records:\n";

// Update all users created before a certain date
$sql = "UPDATE users 
        SET email = CONCAT('updated_', email) 
        WHERE created_at < CURRENT_DATE";

if ($conn->query($sql) === TRUE) {
    echo "Updated " . $conn->affected_rows . " records\n";
} else {
    echo "Error updating records: " . $conn->error . "\n";
}

// Update with complex WHERE clause
$sql = "UPDATE users 
        SET username = CONCAT(username, '_2023') 
        WHERE id > 100 
        AND email LIKE '%@example.com' 
        AND created_at >= '2023-01-01'";

if ($conn->query($sql) === TRUE) {
    echo "Updated " . $conn->affected_rows . " records with complex condition\n";
} else {
    echo "Error updating records: " . $conn->error . "\n";
}

$stmt->close();
$conn->close();
?>