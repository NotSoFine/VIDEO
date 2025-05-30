<!DOCTYPE html>
<html>
<head>
    <title>PHP in HTML Example</title>
</head>
<body>
    <h1>Welcome to my website</h1>
    
    <?php
    $name = "John";
    echo "<p>Hello, $name!</p>";
    ?>

    <p>This is regular HTML</p>

    <?php echo "<p>The time is " . date('H:i:s') . "</p>"; ?>

    <!-- Short echo tag example -->
    <p>Hello, <?= $name ?>!</p>
</body>
</html>