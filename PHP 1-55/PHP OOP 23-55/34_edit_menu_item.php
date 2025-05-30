<?php
require_once '28_database_class.php';

class MenuItemEditor {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getMenuItem($id) {
        $sql = "SELECT * FROM menu_items WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function getCategories() {
        $sql = "SELECT id, name FROM menu_categories ORDER BY name";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
    
    public function updateMenuItem($id, $data) {
        $sql = "UPDATE menu_items 
                SET name = ?, description = ?, price = ?, category_id = ? 
                WHERE id = ?";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('ssdii', 
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $id
        );
        
        return $stmt->execute();
    }
    
    public function displayForm($id) {
        $item = $this->getMenuItem($id);
        if (!$item) {
            echo '<div class="alert alert-danger">Menu item not found.</div>';
            return;
        }
        
        $categories = $this->getCategories();
        ?>
        <div class="container mt-4">
            <h2>Edit Menu Item</h2>
            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="<?php echo htmlspecialchars($item['name']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" 
                              rows="3" required><?php echo htmlspecialchars($item['description']); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" 
                           step="0.01" value="<?php echo $item['price']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                    <?php echo $category['id'] == $item['category_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Menu Item</button>
                <a href="33_menu_pagination.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
        <?php
    }
    
    public function processUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            
            if ($this->updateMenuItem($id, $data)) {
                $_SESSION['success'] = "Menu item updated successfully";
                header('Location: 33_menu_pagination.php');
                exit;
            } else {
                $_SESSION['error'] = "Error updating menu item";
            }
        }
    }
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$editor = new MenuItemEditor();

if ($id > 0) {
    $editor->processUpdate($id);
    $editor->displayForm($id);
} else {
    echo '<div class="alert alert-danger">Invalid menu item ID.</div>';
}
?>