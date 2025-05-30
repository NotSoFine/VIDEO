<?php
require_once '28_database_class.php';

class MenuItemProcessor {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function validateInput($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors[] = "Name is required";
        }
        
        if (empty($data['description'])) {
            $errors[] = "Description is required";
        }
        
        if (!is_numeric($data['price']) || $data['price'] <= 0) {
            $errors[] = "Valid price is required";
        }
        
        if (empty($data['category_id'])) {
            $errors[] = "Category is required";
        }
        
        return $errors;
    }
    
    public function sanitizeInput($data) {
        return array_map(function($item) {
            return htmlspecialchars(strip_tags(trim($item)));
        }, $data);
    }
    
    public function processForm() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: 31_add_menu_item_form.php');
            exit;
        }
        
        $data = $this->sanitizeInput($_POST);
        $errors = $this->validateInput($data);
        
        if (empty($errors)) {
            $sql = "INSERT INTO menu_items (name, description, price, category_id) 
                    VALUES (?, ?, ?, ?)";
            
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('ssdi', 
                $data['name'],
                $data['description'],
                $data['price'],
                $data['category_id']
            );
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Menu item added successfully";
                header('Location: 31_add_menu_item_form.php');
                exit;
            } else {
                $errors[] = "Error adding menu item";
            }
        }
        
        // If there are errors, store them in session and redirect back
        $_SESSION['errors'] = $errors;
        header('Location: 31_add_menu_item_form.php');
        exit;
    }
}

$processor = new MenuItemProcessor();
$processor->processForm();
?>