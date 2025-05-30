<?php
// Arithmetic Operators
$a = 10;
$b = 3;

echo "Arithmetic Operators:\n";
echo "Addition: " . ($a + $b) . "\n";        // 13
echo "Subtraction: " . ($a - $b) . "\n";     // 7
echo "Multiplication: " . ($a * $b) . "\n";  // 30
echo "Division: " . ($a / $b) . "\n";       // 3.333...
echo "Modulus: " . ($a % $b) . "\n";        // 1
echo "Exponentiation: " . ($a ** $b) . "\n"; // 1000

// Increment/Decrement
$c = 5;
echo "\nIncrement/Decrement:\n";
echo "Pre-increment: " . (++$c) . "\n";  // 6
echo "Post-increment: " . ($c++) . "\n"; // 6 (then increases)
echo "Current value: " . $c . "\n";     // 7

// Assignment Operators
echo "\nAssignment Operators:\n";
$x = 10;
$x += 5;  // $x = $x + 5
echo "After +=: " . $x . "\n";
$x -= 3;  // $x = $x - 3
echo "After -=: " . $x . "\n";
$x *= 2;  // $x = $x * 2
echo "After *=: " . $x . "\n";

// Comparison Operators
echo "\nComparison Operators:\n";
$p = 5;
$q = "5";
echo "Loose equality (==): " . ($p == $q) . "\n";    // true (1)
echo "Strict equality (===): " . ($p === $q) . "\n";  // false (empty)
echo "Not equal (!=): " . ($p != 6) . "\n";         // true (1)
echo "Greater than (>): " . ($p > 3) . "\n";        // true (1)

// Logical Operators
echo "\nLogical Operators:\n";
$t = true;
$f = false;
echo "AND (&&): " . ($t && $t) . "\n";  // true (1)
echo "OR (||): " . ($t || $f) . "\n";   // true (1)
echo "NOT (!): " . (!$t) . "\n";       // false (empty)
?>