<?php
// Indexed Arrays
$fruits = ['apple', 'banana', 'orange'];
echo "First fruit: " . $fruits[0] . "\n";

// Creating arrays with array()
$numbers = array(1, 2, 3, 4, 5);

// Associative Arrays
$person = [
    'name' => 'John Doe',
    'age' => 30,
    'city' => 'New York'
];
echo "Name: " . $person['name'] . "\n";

// Multidimensional Arrays
$matrix = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
];
echo "Matrix[1][1]: " . $matrix[1][1] . "\n";

$students = [
    'Class A' => [
        'John' => ['math' => 90, 'english' => 85],
        'Jane' => ['math' => 95, 'english' => 92]
    ],
    'Class B' => [
        'Bob' => ['math' => 88, 'english' => 87],
        'Alice' => ['math' => 92, 'english' => 94]
    ]
];

// Array Functions
echo "\nArray Functions:\n";

// count()
echo "Number of fruits: " . count($fruits) . "\n";

// array_push()
array_push($fruits, 'grape');

// array_pop()
$last = array_pop($fruits);

// array_merge()
$more_numbers = [6, 7, 8];
$all_numbers = array_merge($numbers, $more_numbers);

// print_r()
echo "\nPrinting array structure:\n";
print_r($person);

// var_dump() - more detailed information
echo "\nDetailed array information:\n";
var_dump($fruits);
?>