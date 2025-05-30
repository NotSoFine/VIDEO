<?php
session_start();
require_once '28_database_class.php';

class CustomerLogin {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function validateInput($data) {
        $errors = [];
        
        // Validate email
        if (empty($data['email'])) {
            $errors[] = "Email is required";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
        
        // Validate password
        if (empty($data['password'])) {
            $errors[] = "Password is required";
        }
        
        return $errors;
    }
    
    public function authenticateCustomer($email, $password) {
        // Prepare the SQL statement
        $sql = "SELECT * FROM customers WHERE email = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $customer = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $customer['password'])) {
                // Remove password from session data
                unset($customer['password']);
                
                // Store customer data in session
                $_SESSION['customer'] = $customer;
                return true;
            }
        }
        
        return false;
    }
}

// Process the login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = new CustomerLogin();
    
    // Sanitize input data
    $data = array_map('trim', $_POST);
    
    // Validate input
    $errors = $login->validateInput($data);
    
    if (empty($errors)) {
        // Attempt to authenticate the customer
        if ($login->authenticateCustomer($data['email'], $data['password'])) {
            $_SESSION['message'] = "Welcome back!";
            $_SESSION['message_type'] = "success";
            header('Location: 43_menu_frontend.php');
            exit;
        } else {
            $_SESSION['message'] = "Invalid email or password";
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = implode('<br>', $errors);
        $_SESSION['message_type'] = "danger";
    }
    
    header('Location: 47_customer_login.php');
    exit;
}
?>