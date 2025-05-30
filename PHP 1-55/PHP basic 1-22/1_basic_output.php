<?php
// Using echo statement
echo "Hello World!"; // Simple text output
echo "<h1>This is a heading</h1>"; // HTML output using echo

// Using print statement
print "Hello using print!"; // Simple text output
print "<p>This is a paragraph</p>"; // HTML output using print

// Multiple values with echo (echo can take multiple parameters)
echo "First", " ", "Second"; // Works fine

// Print can only take one argument
// print "One", "Two"; // This would cause an error

// The main difference between echo and print:
// 1. echo can take multiple parameters, print can only take one
// 2. print always returns 1, echo returns void
// 3. echo is marginally faster than print
?>