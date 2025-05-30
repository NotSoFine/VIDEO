<?php
class Database {
    // Private connection properties
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "restaurant_db";
    private $connection;
    
    // Constructor to establish connection
    public function __construct() {
        $this->connect();
    }
    
    // Private method to establish connection
    private function connect() {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );
        
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    
    // Method to execute queries
    public function query($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            die("Query failed: " . $this->connection->error);
        }
        return $result;
    }
    
    // Method to fetch a single row
    public function fetchRow($result) {
        return $result->fetch_assoc();
    }
    
    // Method to fetch all rows
    public function fetchAll($result) {
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    // Method to get connection (if needed)
    public function getConnection() {
        return $this->connection;
    }
    
    // Method to close the database connection
    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Usage Example
$db = new Database();
$result = $db->query("SELECT * FROM menu_items");
$items = $db->fetchAll($result);
?>