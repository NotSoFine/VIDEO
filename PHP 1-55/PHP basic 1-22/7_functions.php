<?php
// Basic function definition
function greet($name) {
    echo "Hello, $name!\n";
}

// Function with return value and type declaration (PHP 7+)
function add(int $a, int $b): int {
    return $a + $b;
}

// Function with default parameter
function welcome($name = "Guest") {
    echo "Welcome, $name!\n";
}

// Function with multiple parameters
function calculateTotal(float $price, float $tax = 0.1): float {
    return $price + ($price * $tax);
}

// Calling these functions
greet("John");                    // With argument
welcome();                       // Without argument (uses default)
echo add(5, 3) . "\n";           // With return value
echo calculateTotal(100) . "\n"; // With default tax rate
echo calculateTotal(100, 0.2);   // With custom tax rate
?>