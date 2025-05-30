<?php
require_once '28_database_class.php';

class CustomerManagement {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function createCustomerTable() {
        $sql = "CREATE TABLE IF NOT EXISTS customers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            phone VARCHAR(20),
            address TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        return $this->db->query($sql);
    }
    
    public function displayCustomers() {
        $sql = "SELECT * FROM customers ORDER BY name";
        $result = $this->db->query($sql);
        $customers = $this->db->fetchAll($result);
        
        echo '<div class="container mt-4">';
        echo '<h2>Customer List</h2>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Email</th>';
        echo '<th>Phone</th>';
        echo '<th>Address</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($customers as $customer) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($customer['name']) . '</td>';
            echo '<td>' . htmlspecialchars($customer['email']) . '</td>';
            echo '<td>' . htmlspecialchars($customer['phone']) . '</td>';
            echo '<td>' . htmlspecialchars($customer['address']) . '</td>';
            echo '<td>';
            echo '<a href="edit_customer.php?id=' . $customer['id'] . '" class="btn btn-sm btn-primary me-2">Edit</a>';
            echo '<a href="delete_customer.php?id=' . $customer['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\');">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
    }
}
?>