<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';

// Connect to MySQL (without selecting a database)
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS my_database";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// Select the database
$conn->select_db('my_database');

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Create products table with different data types
$sql = "CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT UNSIGNED DEFAULT 0,
    is_available BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'products' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Common MySQL Data Types Examples:
/*
Numeric Types:
- INT: Integer values
- DECIMAL(10,2): Precise decimal numbers (e.g., money)
- FLOAT: Approximate decimal numbers
- TINYINT: Small integers (-128 to 127)

String Types:
- VARCHAR(n): Variable-length string, max n characters
- TEXT: Long text
- CHAR(n): Fixed-length string
- ENUM: List of possible values

Date and Time Types:
- DATE: Date only (YYYY-MM-DD)
- TIME: Time only (HH:MM:SS)
- DATETIME: Date and time
- TIMESTAMP: Date and time, auto-updates

Binary Types:
- BLOB: Binary Large Object
- BINARY: Fixed-length binary string
*/

$conn->close();
?>