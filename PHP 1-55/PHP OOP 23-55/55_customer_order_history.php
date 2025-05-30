<?php
require_once '28_database_class.php';
require_once '29_layout_structure.php';

// Ensure customer is logged in
session_start();
if (!isset($_SESSION['customer_id'])) {
    header('Location: 47_customer_login.php');
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

class CustomerOrderHistory {
    private $db;
    private $customer_id;

    public function __construct($db, $customer_id) {
        $this->db = $db;
        $this->customer_id = $customer_id;
    }

    public function getOrderHistory() {
        $sql = "SELECT o.order_id, o.order_date, o.total_amount, o.status, o.payment_status,
                       oi.item_id, oi.quantity, oi.unit_price,
                       mi.item_name
                FROM orders o
                JOIN order_items oi ON o.order_id = oi.order_id
                JOIN menu_items mi ON oi.item_id = mi.item_id
                WHERE o.customer_id = ?
                ORDER BY o.order_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $this->customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $order_id = $row['order_id'];
            if (!isset($orders[$order_id])) {
                $orders[$order_id] = [
                    'order_id' => $order_id,
                    'order_date' => $row['order_date'],
                    'total_amount' => $row['total_amount'],
                    'status' => $row['status'],
                    'payment_status' => $row['payment_status'],
                    'items' => []
                ];
            }
            
            $orders[$order_id]['items'][] = [
                'item_name' => $row['item_name'],
                'quantity' => $row['quantity'],
                'unit_price' => $row['unit_price'],
                'subtotal' => $row['quantity'] * $row['unit_price']
            ];
        }
        
        return $orders;
    }
}

// Create instance and get order history
$orderHistory = new CustomerOrderHistory($db, $_SESSION['customer_id']);
$orders = $orderHistory->getOrderHistory();

// Display the page
render_header('Order History');
?>

<div class="container mt-4">
    <h2>Your Order History</h2>
    
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">You haven't placed any orders yet.</div>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Order #<?php echo htmlspecialchars($order['order_id']); ?></h5>
                        <small class="text-muted">Placed on: <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></small>
                    </div>
                    <div>
                        <span class="badge bg-<?php echo $order['status'] === 'completed' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                        </span>
                        <span class="badge bg-<?php echo $order['payment_status'] === 'paid' ? 'success' : 'danger'; ?>">
                            <?php echo ucfirst(htmlspecialchars($order['payment_status'])); ?>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                                    <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
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
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

render_footer();
$db->closeConnection();
?>