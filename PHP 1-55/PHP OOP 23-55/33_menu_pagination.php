<?php
require_once '28_database_class.php';

class MenuPagination {
    private $db;
    private $itemsPerPage = 10;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getTotalPages() {
        $sql = "SELECT COUNT(*) as total FROM menu_items";
        $result = $this->db->query($sql);
        $row = $this->db->fetchRow($result);
        return ceil($row['total'] / $this->itemsPerPage);
    }
    
    public function getMenuItems($page = 1) {
        $offset = ($page - 1) * $this->itemsPerPage;
        
        $sql = "SELECT m.*, c.name as category_name 
                FROM menu_items m 
                JOIN menu_categories c ON m.category_id = c.id 
                ORDER BY m.name 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('ii', $this->itemsPerPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function displayPagination($currentPage, $totalPages) {
        echo '<nav aria-label="Menu pagination">';
        echo '<ul class="pagination justify-content-center">';
        
        // Previous button
        $prevDisabled = $currentPage <= 1 ? ' disabled' : '';
        echo "<li class='page-item{$prevDisabled}'>
                <a class='page-link' href='?page=" . ($currentPage - 1) . "'>Previous</a>
              </li>";
        
        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i == $currentPage ? ' active' : '';
            echo "<li class='page-item{$active}'>
                    <a class='page-link' href='?page={$i}'>{$i}</a>
                  </li>";
        }
        
        // Next button
        $nextDisabled = $currentPage >= $totalPages ? ' disabled' : '';
        echo "<li class='page-item{$nextDisabled}'>
                <a class='page-link' href='?page=" . ($currentPage + 1) . "'>Next</a>
              </li>";
        
        echo '</ul></nav>';
    }
    
    public function display() {
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $totalPages = $this->getTotalPages();
        $items = $this->getMenuItems($currentPage);
        
        echo '<div class="container mt-4">';
        echo '<h2>Menu Items</h2>';
        
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Description</th>';
        echo '<th>Price</th>';
        echo '<th>Category</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        foreach ($items as $item) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($item['name']) . '</td>';
            echo '<td>' . htmlspecialchars($item['description']) . '</td>';
            echo '<td>$' . number_format($item['price'], 2) . '</td>';
            echo '<td>' . htmlspecialchars($item['category_name']) . '</td>';
            echo '<td>';
            echo '<a href="34_edit_menu_item.php?id=' . $item['id'] . '" class="btn btn-sm btn-primary me-2">Edit</a>';
            echo '<a href="35_delete_menu_item.php?id=' . $item['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\');">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        
        $this->displayPagination($currentPage, $totalPages);
        echo '</div>';
    }
}

$menuPagination = new MenuPagination();
$menuPagination->display();
?>