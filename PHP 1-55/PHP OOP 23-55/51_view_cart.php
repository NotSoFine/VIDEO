<?php
session_start();
require_once '49_shopping_cart.php';

$cart = new ShoppingCart();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <h2>Your Shopping Cart</h2>
        
        <?php if (empty($cart->getItems())): ?>
            <div class="alert alert-info">Your cart is empty.</div>
            <a href="43_menu_frontend.php" class="btn btn-primary">Continue Shopping</a>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart->getItems() as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <div class="input-group" style="width: 150px;">
                                        <button class="btn btn-outline-secondary quantity-btn" data-action="decrease" data-item-id="<?php echo $item['id']; ?>">-</button>
                                        <input type="number" class="form-control text-center quantity-input" value="<?php echo $item['quantity']; ?>" data-item-id="<?php echo $item['id']; ?>">
                                        <button class="btn btn-outline-secondary quantity-btn" data-action="increase" data-item-id="<?php echo $item['id']; ?>">+</button>
                                    </div>
                                </td>
                                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm remove-item" data-item-id="<?php echo $item['id']; ?>">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td colspan="2"><strong>$<?php echo number_format($cart->getTotal(), 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="43_menu_frontend.php" class="btn btn-secondary">Continue Shopping</a>
                <a href="#" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle quantity changes
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                let quantity = parseInt(input.value);
                
                if (this.dataset.action === 'increase') {
                    quantity++;
                } else {
                    quantity = Math.max(0, quantity - 1);
                }
                
                updateCartItem(itemId, quantity);
            });
        });
        
        // Handle manual quantity input
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.dataset.itemId;
                const quantity = Math.max(0, parseInt(this.value) || 0);
                updateCartItem(itemId, quantity);
            });
        });
        
        // Handle remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                updateCartItem(itemId, 0);
            });
        });
        
        function updateCartItem(itemId, quantity) {
            fetch('50_cart_operations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=update&item_id=${itemId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh to show updated cart
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
    </script>
</body>
</html>