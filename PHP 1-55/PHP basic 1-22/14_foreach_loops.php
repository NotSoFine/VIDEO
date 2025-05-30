<?php
// Basic foreach with values only
$colors = ['red', 'blue', 'green'];
foreach ($colors as $color) {
    echo "Color: $color\n";
}

// Foreach with key and value
$ages = [
    'John' => 25,
    'Jane' => 30,
    'Bob' => 35
];

foreach ($ages as $name => $age) {
    echo "$name is $age years old\n";
}

// Break in foreach
$numbers = [1, 2, 3, 4, 5];
foreach ($numbers as $number) {
    if ($number == 4) {
        break;
    }
    echo "Number: $number\n";
}

// Continue in foreach
$scores = [85, 92, 78, 95, 88];
foreach ($scores as $index => $score) {
    if ($score < 90) {
        continue;
    }
    echo "High score at position $index: $score\n";
}

// Nested foreach loops
$students = [
    'Class A' => ['John', 'Jane', 'Bob'],
    'Class B' => ['Alice', 'Charlie', 'David']
];

foreach ($students as $class => $names) {
    echo "\n$class students:\n";
    foreach ($names as $name) {
        echo "- $name\n";
    }
}
?>