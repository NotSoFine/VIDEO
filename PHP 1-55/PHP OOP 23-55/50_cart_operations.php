<?php
session_start();
require_once '28_database_class.php';
require_once '49_shopping_cart.php';

class CartOperations {
    private $db;
    private $cart;
    
    public function __construct() {
        $this->db = new Database();
        $this->cart = new ShoppingCart();
    }
    
    public function handleRequest() {
        $action = $_POST['action'] ?? '';
        $itemId = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
        
        switch ($action) {
            case 'add':
                $this->addToCart($itemId);
                break;
            case 'remove':
                $this->removeFromCart($itemId);
                break;
            case 'update':
                $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
                $this->updateCartItem($itemId, $quantity);
                break;
        }
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'cartTotal' => $this->cart->getTotal(),
            'itemCount' => count($this->cart->getItems())
        ]);
        exit;
    }
    
    private function addToCart($itemId) {
        $sql = "SELECT id, name, price FROM menu_items WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($item = $result->fetch_assoc()) {
            $this->cart->addItem($item);
        }
    }
    
    private function removeFromCart($itemId) {
        $this->cart->removeItem($itemId);
    }
    
    private function updateCartItem($itemId, $quantity) {
        $this->cart->updateQuantity($itemId, $quantity);
    }
}

// Handle cart operations if this file is accessed directly
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operations = new CartOperations();
    $operations->handleRequest();
}
?>