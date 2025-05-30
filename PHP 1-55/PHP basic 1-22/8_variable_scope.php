<?php
// Global variable
$globalVar = "I'm global";

// Function demonstrating local scope
function testLocalScope() {
    $localVar = "I'm local";
    echo "Inside function: $localVar\n";
    // echo $globalVar; // This would cause an error
}

// Function using global keyword
function testGlobalKeyword() {
    global $globalVar;
    echo "Accessing global: $globalVar\n";
}

// Function using $GLOBALS array
function testGlobalsArray() {
    echo "Using GLOBALS: " . $GLOBALS['globalVar'] . "\n";
}

// Static variable example
function countCalls() {
    static $count = 0;
    $count++;
    echo "This function has been called $count time(s)\n";
}

testLocalScope();
testGlobalKeyword();
testGlobalsArray();

// Call countCalls multiple times
countCalls();
countCalls();
countCalls();
?>