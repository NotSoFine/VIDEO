<?php
require_once '28_database_class.php';
require_once '29_layout_structure.php';

// Ensure admin is logged in
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: 41_login.php');
    exit();
}

// Database connection
$db_params = [
    'host' => 'localhost',
    'username' => 'root',  // Changed from 'your_username'
    'password' => '',      // Changed from 'your_password'
    'database' => 'restaurant_db'  // Changed from 'your_database'
];

$db = new Database($db_params);

class AdminOrderManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllOrders() {
        $sql = "SELECT o.order_id, o.order_date, o.total_amount, o.status, o.payment_status,
                       c.customer_id, c.name as customer_name, c.email,
                       COUNT(oi.item_id) as item_count
                FROM orders o
                JOIN customers c ON o.customer_id = c.customer_id
                JOIN order_items oi ON o.order_id = oi.order_id
                GROUP BY o.order_id, o.order_date, o.total_amount, o.status, o.payment_status,
                          c.customer_id, c.name, c.email
                ORDER BY o.order_date DESC";
        
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateOrderStatus($order_id, $status) {
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $status, $order_id);
        return $stmt->execute();
    }

    public function updatePaymentStatus($order_id, $payment_status) {
        $sql = "UPDATE orders SET payment_status = ? WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $payment_status, $order_id);
        return $stmt->execute();
    }

    public function getOrderDetails($order_id) {
        $sql = "SELECT oi.item_id, oi.quantity, oi.unit_price,
                       mi.item_name
                FROM order_items oi
                JOIN menu_items mi ON oi.item_id = mi.item_id
                WHERE oi.order_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// Process status updates if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderManager = new AdminOrderManager($db);
    
    if (isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['status'];
        $orderManager->updateOrderStatus($order_id, $new_status);
    }
    
    if (isset($_POST['update_payment'])) {
        $order_id = $_POST['order_id'];
        $new_payment_status = $_POST['payment_status'];
        $orderManager->updatePaymentStatus($order_id, $new_payment_status);
    }
    
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Get all orders
$orderManager = new AdminOrderManager($db);
$orders = $orderManager->getAllOrders();

// Display the page
render_header('Admin - Order Management');
?>

<div class="container mt-4">
    <h2>Order Management</h2>
    
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">No orders found.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($order['customer_name']); ?><br>
                                <small class="text-muted"><?php echo htmlspecialchars($order['email']); ?></small>
                            </td>
                            <td><?php echo date('Y-m-d H:i', strtotime($order['order_date'])); ?></td>
                            <td><?php echo htmlspecialchars($order['item_count']); ?> items</td>
                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 100px;">
                                        <?php foreach (['pending', 'processing', 'completed', 'cancelled'] as $status): ?>
                                            <option value="<?php echo $status; ?>" <?php echo $order['status'] === $status ? 'selected' : ''; ?>>
                                                <?php echo ucfirst($status); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 100px;">
                                        <?php foreach (['pending', 'paid', 'refunded'] as $status): ?>
                                            <option value="<?php echo $status; ?>" <?php echo $order['payment_status'] === $status ? 'selected' : ''; ?>>
                                                <?php echo ucfirst($status); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="update_payment" value="1">
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['order_id']; ?>">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Order Details Modal -->
                        <div class="modal fade" id="orderModal<?php echo $order['order_id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Order #<?php echo htmlspecialchars($order['order_id']); ?> Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $orderItems = $orderManager->getOrderDetails($order['order_id']);
                                        if (!empty($orderItems)):
                                        ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($orderItems as $item): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                                            <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                                                            <td>$<?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3" class="text-end">Total:</th>
                                                        <th>$<?php echo number_format($order['total_amount'], 2); ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        <?php else: ?>
                                            <p class="text-muted">No items found for this order.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

render_footer();
$db->closeConnection();
?>