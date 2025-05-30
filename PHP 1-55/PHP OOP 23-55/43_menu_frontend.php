<?php
require_once '28_database_class.php';

class MenuFrontend {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function displayCategories() {
        $sql = "SELECT * FROM menu_categories ORDER BY name";
        $result = $this->db->query($sql);
        $categories = $this->db->fetchAll($result);
        
        echo '<div class="container mt-4">';
        echo '<div class="row">';
        
        foreach ($categories as $category) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card h-100">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($category['name']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($category['description']) . '</p>';
            echo '<a href="?category=' . $category['id'] . '" class="btn btn-primary">View Items</a>';
            echo '</div></div></div>';
        }
        
        echo '</div></div>';
    }
    
    public function displayMenuItems($categoryId = null) {
        $sql = "SELECT m.*, c.name as category_name 
                FROM menu_items m 
                JOIN menu_categories c ON m.category_id = c.id";
        
        if ($categoryId) {
            $sql .= " WHERE m.category_id = ?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bind_param('i', $categoryId);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->db->query($sql);
        }
        
        $items = $result->fetch_all(MYSQLI_ASSOC);
        
        echo '<div class="container mt-4">';
        echo '<div class="row">';
        
        foreach ($items as $item) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card h-100">';
            
            if (!empty($item['image_path']) && file_exists($item['image_path'])) {
                echo '<img src="' . htmlspecialchars($item['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($item['name']) . '">';
            }
            
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($item['name']) . '</h5>';
            echo '<p class="card-text">' . htmlspecialchars($item['description']) . '</p>';
            echo '<p class="card-text"><small class="text-muted">Category: ' . htmlspecialchars($item['category_name']) . '</small></p>';
            echo '<p class="card-text"><strong>$' . number_format($item['price'], 2) . '</strong></p>';
            echo '<button class="btn btn-primary add-to-cart" data-item-id="' . $item['id'] . '">Add to Cart</button>';
            echo '</div></div></div>';
        }
        
        echo '</div></div>';
    }
    
    public function display() {
        $categoryId = isset($_GET['category']) ? intval($_GET['category']) : null;
        
        echo '<div class="container-fluid">';
        echo '<div class="row">';
        
        // Sidebar with categories
        echo '<div class="col-md-3">';
        echo '<h3>Categories</h3>';
        $this->displayCategories();
        echo '</div>';
        
        // Main content area with menu items
        echo '<div class="col-md-9">';
        echo '<h2>Menu Items</h2>';
        $this->displayMenuItems($categoryId);
        echo '</div>';
        
        echo '</div></div>';
    }
}

$menu = new MenuFrontend();
$menu->display();
?>


document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const itemId = this.dataset.itemId;
        
        fetch('50_cart_operations.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=add&item_id=${itemId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Item added to cart!');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});