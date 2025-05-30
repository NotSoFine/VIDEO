<?php
require_once '28_database_class.php';

class UserProcessor {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function validateInput($data) {
        $errors = [];
        
        if (empty($data['username'])) {
            $errors[] = "Username is required";
        }
        
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required";
        }
        
        if (empty($data['password'])) {
            $errors[] = "Password is required";
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Passwords do not match";
        }
        
        if (!in_array($data['role'], ['admin', 'staff'])) {
            $errors[] = "Invalid role selected";
        }
        
        return $errors;
    }
    
    public function processForm() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: 39_add_user_form.php');
            exit;
        }
        
        $data = array_map('trim', $_POST);
        $errors = $this->validateInput($data);
        
        if (empty($errors)) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('ssss', 
                $data['username'],
                $data['email'],
                $hashedPassword,
                $data['role']
            );
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "User added successfully";
                header('Location: 38_user_management.php');
                exit;
            } else {
                $errors[] = "Error adding user";
            }
        }
        
        $_SESSION['errors'] = $errors;
        header('Location: 39_add_user_form.php');
        exit;
    }
}

$processor = new UserProcessor();
$processor->processForm();
?>