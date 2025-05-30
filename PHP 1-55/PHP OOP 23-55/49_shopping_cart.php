<?php
session_start();

class ShoppingCart {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    
    public function addItem($item) {
        $itemId = $item['id'];
        
        // If item already exists, increase quantity
        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId]['quantity']++;
        } else {
            // Add new item with quantity 1
            $_SESSION['cart'][$itemId] = [
                'id' => $itemId,
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => 1
            ];
        }
    }
    
    public function removeItem($itemId) {
        if (isset($_SESSION['cart'][$itemId])) {
            unset($_SESSION['cart'][$itemId]);
            return true;
        }
        return false;
    }
    
    public function updateQuantity($itemId, $quantity) {
        if (isset($_SESSION['cart'][$itemId])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$itemId]['quantity'] = $quantity;
            } else {
                $this->removeItem($itemId);
            }
            return true;
        }
        return false;
    }
    
    public function getItems() {
        return $_SESSION['cart'];
    }
    
    public function getTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
    
    public function clear() {
        $_SESSION['cart'] = [];
    }
}
?>