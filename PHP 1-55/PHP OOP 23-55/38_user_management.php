<?php
require_once '28_database_class.php';

class UserManagement {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function createUserTable() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
            is_active BOOLEAN NOT NULL DEFAULT TRUE,
            last_login TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        return $this->db->query($sql);
    }
    
    public function displayUsers() {
        $sql = "SELECT id, username, email, role, is_active, last_login FROM users ORDER BY username";
        $result = $this->db->query($sql);
        $users = $this->db->fetchAll($result);
        
        echo '<div class="container mt-4">';
        echo '<h2>User Management</h2>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Username</th>';
        echo '<th>Email</th>';
        echo '<th>Role</th>';
        echo '<th>Status</th>';
        echo '<th>Last Login</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($user['username']) . '</td>';
            echo '<td>' . htmlspecialchars($user['email']) . '</td>';
            echo '<td>' . htmlspecialchars($user['role']) . '</td>';
            echo '<td>' . ($user['is_active'] ? 'Active' : 'Inactive') . '</td>';
            echo '<td>' . ($user['last_login'] ? date('Y-m-d H:i:s', strtotime($user['last_login'])) : 'Never') . '</td>';
            echo '<td>';
            echo '<a href="edit_user.php?id=' . $user['id'] . '" class="btn btn-sm btn-primary me-2">Edit</a>';
            if ($user['is_active']) {
                echo '<a href="deactivate_user.php?id=' . $user['id'] . '" class="btn btn-sm btn-warning me-2">Deactivate</a>';
            } else {
                echo '<a href="activate_user.php?id=' . $user['id'] . '" class="btn btn-sm btn-success me-2">Activate</a>';
            }
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