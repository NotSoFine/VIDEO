<?php
// Add these functions at the beginning of the file
function render_header($title) {
    ?><!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($title); ?> - Restaurant App</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Restaurant</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="menu.php">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reservations.php">Reservations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <?php
}

function render_footer() {
    ?>
    <footer class="bg-dark text-white mt-5">
        <div class="container py-3">
            <p>&copy; <?php echo date('Y'); ?> Restaurant. All rights reserved.</p>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}

// index.php (example of using the layout)
// Include header
require_once 'header.php';
?>

<!-- Dynamic Content Area -->
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1>Welcome to Our Restaurant</h1>
            <!-- Page-specific content goes here -->
            <?php
            // Example of dynamic content
            $specialOfTheDay = "Grilled Salmon";
            echo "<p>Today's Special: $specialOfTheDay</p>";
            ?>
        </div>
    </div>
</div>

<?php
// Include footer
require_once 'footer.php';
?>