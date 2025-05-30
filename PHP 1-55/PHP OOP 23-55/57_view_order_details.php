<?php
require_once '28_database_class.php';
require_once '29_layout_structure.php';

class OrderDetailsViewer {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getOrderDetails($order_id) {
        // Get order header information
        $sql = "SELECT o.order_id, o.order_date, o.total_amount, o.status, o.payment_status,
                       c.name as customer_name, c.email, c.phone
                FROM orders o
                JOIN customers c ON o.customer_id = c.customer_id
                WHERE o.order_id = ?";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();

        if (!$order) {
            return null;
        }

        // Get order items
        $sql = "SELECT oi.item_id, oi.quantity, oi.unit_price,
                       mi.item_name, mi.description
                FROM order_items oi
                JOIN menu_items mi ON oi.item_id = mi.item_id
                WHERE oi.order_id = ?";
        
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order['items'] = $result->fetch_all(MYSQLI_ASSOC);

        return $order;
    }

    public function displayOrderDetails($order_id) {
        $order = $this->getOrderDetails($order_id);
        if (!$order) {
            echo '<div class="alert alert-danger">Order not found.</div>';
            return;
        }

        ?>
        <div class="container mt-4">
            <h2>Order #<?php echo htmlspecialchars($order_id); ?> Details</h2>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Order Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-<?php echo $order['status'] === 'completed' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                        </span>
                    </p>
                    <p><strong>Payment Status:</strong>
                        <span class="badge bg-<?php echo $order['payment_status'] === 'paid' ? 'success' : 'danger'; ?>">
                            <?php echo ucfirst(htmlspecialchars($order['payment_status'])); ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                                    <td>$<?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total:</th>
                                <th>$<?php echo number_format($order['total_amount'], 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}

// Check if user is logged in and has admin role
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: 41_login.php');
    exit();
}

// Get order ID from URL
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Display the page
render_header('Order Details');

$viewer = new OrderDetailsViewer();
$viewer->displayOrderDetails($order_id);

render_footer();
?>