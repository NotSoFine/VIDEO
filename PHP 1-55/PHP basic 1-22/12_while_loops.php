<?php
// Basic while loop
$count = 1;
while ($count <= 5) {
    echo "Count: $count\n";
    $count++;
}

// While loop with break
$num = 1;
while (true) {
    if ($num > 5) {
        break;
    }
    echo "Number: $num\n";
    $num++;
}

// While loop with continue
$i = 0;
while ($i < 10) {
    $i++;
    if ($i % 2 == 0) { // Skip even numbers
        continue;
    }
    echo "Odd number: $i\n";
}

// Common use case: Reading file contents
echo "\nFile reading example (simulated):\n";
$lines = ["Line 1", "Line 2", "Line 3", "Line 4"];
$currentLine = 0;

while ($currentLine < count($lines)) {
    echo $lines[$currentLine] . "\n";
    $currentLine++;
}

// Processing user input (simulated)
echo "\nUser input processing (simulated):\n";
$userInputs = ["hello", "how are you", "quit", "goodbye"];
$index = 0;

while ($index < count($userInputs)) {
    $input = $userInputs[$index];
    if ($input === "quit") {
        echo "Quitting the program\n";
        break;
    }
    echo "Processing: $input\n";
    $index++;
}
?>