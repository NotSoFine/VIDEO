<?php
// Variable declaration and assignment
$name = "John"; // String variable
$age = 25;      // Integer variable
$price = 19.99; // Float variable
$isStudent = true; // Boolean variable

// Variable naming conventions
$firstName = "John";    // camelCase
$last_name = "Doe";    // snake_case
$_private = "Hidden";  // Starting with underscore
$price2 = 29.99;       // Numbers allowed (but not at start)

// Variable concatenation
echo "My name is $name and I am $age years old.\n";
// Alternative concatenation
echo 'My name is ' . $name . ' and I am ' . $age . ' years old.\n';

// Variable reassignment
$name = "Jane";
echo "Now my name is $name\n";

// Variable scope
$global_var = "I'm global";
function testScope() {
    global $global_var; // Accessing global variable
    $local_var = "I'm local";
    echo $global_var . "\n";
    echo $local_var . "\n";
}
?>