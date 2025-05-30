<?php
session_start();
require_once '28_database_class.php';

class OrderConfirmation {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getOrderDetails($orderId) {
        // Get order information
        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        
        if (!$order) return null;
        
        // Get order items
        $sql = "SELECT oi.*, mi.name 
                FROM order_items oi 
                JOIN menu_items mi ON oi.menu_item_id = mi.id 
                WHERE oi.order_id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $order['items'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        return $order;
    }
}

$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$confirmation = new OrderConfirmation();
$order = $confirmation->getOrderDetails($orderId);

if (!$order) {
    header('Location: 43_menu_frontend.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">Order Confirmed!</h3>
                    </div>
                    <div class="card-body">
                        <h4>Thank you for your order, <?php echo htmlspecialchars($order['customer_name']); ?>!</h4>
                        <p>Your order number is: <strong>#<?php echo $order['id']; ?></strong></p>
                        <p>Order Date: <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></p>
                        
                        <h5 class="mt-4">Order Details:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>$<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <h5 class="mt-4">Delivery Information:</h5>
                        <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($order['address'])); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                        
                        <?php if (!empty($order['notes'])): ?>
                            <p><strong>Order Notes:</strong> <?php echo nl2br(htmlspecialchars($order['notes'])); ?></p>
                        <?php endif; ?>
                        
                        <div class="mt-4 text-center">
                            <a href="43_menu_frontend.php" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>