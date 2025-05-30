<?php
session_start();
require_once '28_database_class.php';
require_once '49_shopping_cart.php';

class OrderProcessor {
    private $db;
    private $cart;
    
    public function __construct() {
        $this->db = new Database();
        $this->cart = new ShoppingCart();
    }
    
    public function validateInput($data) {
        $errors = [];
        
        if (empty($data['name'])) $errors[] = "Name is required";
        if (empty($data['email'])) $errors[] = "Email is required";
        if (empty($data['phone'])) $errors[] = "Phone is required";
        if (empty($data['address'])) $errors[] = "Address is required";
        
        return $errors;
    }
    
    public function createOrder($data) {
        try {
            $this->db->getConnection()->begin_transaction();
            
            // Insert into orders table
            $sql = "INSERT INTO orders (customer_id, customer_name, email, phone, address, notes, total_amount, order_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $this->db->getConnection()->prepare($sql);
            $customerId = $_SESSION['customer']['id'] ?? null;
            $totalAmount = $this->cart->getTotal();
            
            $stmt->bind_param('isssssd',
                $customerId,
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['address'],
                $data['notes'],
                $totalAmount
            );
            
            $stmt->execute();
            $orderId = $this->db->getConnection()->insert_id;
            
            // Insert order items
            $sql = "INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            
            foreach ($this->cart->getItems() as $item) {
                $stmt->bind_param('iiid',
                    $orderId,
                    $item['id'],
                    $item['quantity'],
                    $item['price']
                );
                $stmt->execute();
            }
            
            $this->db->getConnection()->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw $e;
        }
    }
}

// Process the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $processor = new OrderProcessor();
    
    // Validate input
    $data = array_map('trim', $_POST);
    $errors = $processor->validateInput($data);
    
    if (empty($errors)) {
        try {
            // Create the order
            $orderId = $processor->createOrder($data);
            
            // Clear the cart
            $cart = new ShoppingCart();
            $cart->clear();
            
            // Set success message
            $_SESSION['message'] = "Order placed successfully! Your order number is #{$orderId}";
            $_SESSION['message_type'] = "success";
            
            // Redirect to confirmation page
            header('Location: 54_order_confirmation.php?order_id=' . $orderId);
            exit;
            
        } catch (Exception $e) {
            $_SESSION['message'] = "Error processing order: " . $e->getMessage();
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = implode('<br>', $errors);
        $_SESSION['message_type'] = "danger";
    }
    
    // If there were errors, redirect back to checkout
    header('Location: 52_checkout.php');
    exit;
}
?>