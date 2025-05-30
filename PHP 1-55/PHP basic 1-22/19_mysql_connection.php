<?php
// Database connection parameters
$host = 'localhost';      // Usually 'localhost' for local development
$username = 'root';       // Your MySQL username
$password = '';          // Your MySQL password
$database = 'test_db';   // Your database name

// Create connection using mysqli
try {
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully to MySQL database!\n";

    // Set character set (optional but recommended)
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}

// Alternative procedural style connection
$conn2 = mysqli_connect($host, $username, $password, $database);

// Check connection (procedural style)
if (!$conn2) {
    die("Connection failed: " . mysqli_connect_error() . "\n");
}

// Close connections when done
$conn->close();
mysqli_close($conn2);
?>