<?php
// Basic for loop structure
for ($i = 1; $i <= 5; $i++) {
    echo "Iteration $i\n";
}

// For loop with break
for ($i = 1; $i <= 10; $i++) {
    if ($i > 5) {
        break;
    }
    echo "Number: $i\n";
}

// For loop with continue
for ($i = 1; $i <= 5; $i++) {
    if ($i == 3) {
        continue;
    }
    echo "Value: $i\n";
}

// Common use cases

// 1. Array iteration
$numbers = [1, 2, 3, 4, 5];
for ($i = 0; $i < count($numbers); $i++) {
    echo "Array element $i: " . $numbers[$i] . "\n";
}

// 2. Table generation
echo "<table border='1'>\n";
for ($row = 1; $row <= 3; $row++) {
    echo "<tr>\n";
    for ($col = 1; $col <= 3; $col++) {
        echo "<td>Row $row, Col $col</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";

// 3. String manipulation
$text = "Hello";
for ($i = 0; $i < strlen($text); $i++) {
    echo "Character at position $i: " . $text[$i] . "\n";
}
?>