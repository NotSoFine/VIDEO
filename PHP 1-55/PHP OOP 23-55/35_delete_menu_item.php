<?php
require_once '28_database_class.php';

class MenuItemDeleter {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function deleteMenuItem($id) {
        $sql = "DELETE FROM menu_items WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Menu item deleted successfully";
        } else {
            $_SESSION['error'] = "Error deleting menu item";
        }
        
        header('Location: 33_menu_pagination.php');
        exit;
    }
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $deleter = new MenuItemDeleter();
    $deleter->deleteMenuItem($id);
} else {
    $_SESSION['error'] = "Invalid menu item ID";
    header('Location: 33_menu_pagination.php');
    exit;
}
?>