<?php
session_start();
require_once '28_database_class.php';

class LoginProcessor {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: 41_login.php');
            exit;
        }
        
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Both username and password are required";
            header('Location: 41_login.php');
            exit;
        }
        
        $sql = "SELECT id, username, password, role FROM users WHERE username = ? AND is_active = 1";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            // Update last login time
            $updateSql = "UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?";
            $updateStmt = $this->db->getConnection()->prepare($updateSql);
            $updateStmt->bind_param('i', $user['id']);
            $updateStmt->execute();
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: 38_user_management.php');
            } else {
                header('Location: 43_menu_frontend.php');
            }
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header('Location: 41_login.php');
            exit;
        }
    }
}

$processor = new LoginProcessor();
$processor->processLogin();
?>