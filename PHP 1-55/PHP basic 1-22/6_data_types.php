<?php
// String
$string1 = "Hello World"; // Double quotes
$string2 = 'Hello World'; // Single quotes

// Integer
$int1 = 42;
$int2 = -17;

// Float (Double)
$float1 = 3.14;
$float2 = -2.5;

// Boolean
$bool1 = true;
$bool2 = false;

// Array
$numbersArray = [1, 2, 3, 4, 5]; // Indexed array
$associativeArray = [
    "name" => "John",
    "age" => 25,
    "city" => "New York"
]; // Associative array

// Checking data types
echo "Type of string1: " . gettype($string1) . "\n";
echo "Type of int1: " . gettype($int1) . "\n";
echo "Type of float1: " . gettype($float1) . "\n";
echo "Type of bool1: " . gettype($bool1) . "\n";
echo "Type of numbersArray: " . gettype($numbersArray) . "\n";

// Type casting
$number = 42;
$stringNumber = (string)$number; // Convert to string
$backToNumber = (int)$stringNumber; // Convert back to integer

// Checking if variable is of specific type
var_dump(is_string($string1));
var_dump(is_int($int1));
var_dump(is_float($float1));
var_dump(is_bool($bool1));
var_dump(is_array($numbersArray));
?>