<?php
require_once '28_database_class.php';

class MenuCategories {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getCategories() {
        $sql = "SELECT id, name, description FROM menu_categories ORDER BY name";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
    
    public function displayCategories() {
        $categories = $this->getCategories();
        
        echo '<div class="container mt-4">';
        echo '<div class="row">';
        
        foreach ($categories as $category) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($category['name']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($category['description']) . '</p>';
            echo '</div></div></div>';
        }
        
        echo '</div></div>';
    }
}

// Usage
$menuCategories = new MenuCategories();
$menuCategories->displayCategories();
?>