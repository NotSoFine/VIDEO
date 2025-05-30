<?php
require_once '28_database_class.php';

class MenuItemForm {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getCategories() {
        $sql = "SELECT id, name FROM menu_categories ORDER BY name";
        $result = $this->db->query($sql);
        return $this->db->fetchAll($result);
    }
    
    public function displayForm() {
        $categories = $this->getCategories();
        ?>
        <div class="container mt-4">
            <h2>Add New Menu Item</h2>
            <form action="32_process_menu_item.php" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">Please enter an item name.</div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    <div class="invalid-feedback">Please enter a description.</div>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    <div class="invalid-feedback">Please enter a valid price.</div>
                </div>
                
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a category.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Add Menu Item</button>
            </form>
        </div>
        <?php
    }
}

$form = new MenuItemForm();
$form->displayForm();
?>