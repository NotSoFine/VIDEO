<?php
// Complete HTML document structure within PHP
echo "<!DOCTYPE html>
<html>
<head>
    <title>My PHP Website</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
    </header>
    
    <main>
        <p>This is the main content area.</p>
    </main>
    
    <footer>
        <p>&copy; " . date('Y') . " My Website</p>
    </footer>
</body>
</html>";
?>