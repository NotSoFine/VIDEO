<?php
require_once '28_database_class.php';

class MenuItemImage {
    private $db;
    private $uploadDir = 'uploads/menu_items/';
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    private $maxSize = 5242880; // 5MB
    
    public function __construct() {
        $this->db = new Database();
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }
    
    public function displayUploadForm($menuItemId) {
        ?>
        <div class="container mt-4">
            <h2>Upload Menu Item Image</h2>
            <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="menu_item_id" value="<?php echo $menuItemId; ?>">
                
                <div class="mb-3">
                    <label for="image" class="form-label">Select Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    <div class="invalid-feedback">Please select an image file.</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Upload Image</button>
            </form>
        </div>
        <?php
    }
    
    public function processUpload($menuItemId) {
        if (!isset($_FILES['image'])) {
            return ['error' => 'No file uploaded'];
        }
        
        $file = $_FILES['image'];
        
        // Validate file
        if (!in_array($file['type'], $this->allowedTypes)) {
            return ['error' => 'Invalid file type. Only JPG, PNG and GIF are allowed'];
        }
        
        if ($file['size'] > $this->maxSize) {
            return ['error' => 'File is too large. Maximum size is 5MB'];
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('menu_') . '.' . $extension;
        $filepath = $this->uploadDir . $filename;
        
        // Move file to upload directory
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return ['error' => 'Failed to move uploaded file'];
        }
        
        // Update database with image path
        $sql = "UPDATE menu_items SET image_path = ? WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('si', $filepath, $menuItemId);
        
        if (!$stmt->execute()) {
            unlink($filepath); // Delete uploaded file if database update fails
            return ['error' => 'Failed to update database'];
        }
        
        return ['success' => 'Image uploaded successfully', 'path' => $filepath];
    }
    
    public function displayImage($menuItemId) {
        $sql = "SELECT image_path FROM menu_items WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $menuItemId);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        
        if ($item && $item['image_path'] && file_exists($item['image_path'])) {
            echo '<img src="' . htmlspecialchars($item['image_path']) . '" class="img-fluid" alt="Menu Item Image">';
        } else {
            echo '<img src="default-menu-item.jpg" class="img-fluid" alt="Default Menu Item Image">';
        }
    }
}
?>