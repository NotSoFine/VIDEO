<?php
// Basic switch statement
$dayOfWeek = 3;

switch ($dayOfWeek) {
    case 1:
        echo "Monday\n";
        break;
    case 2:
        echo "Tuesday\n";
        break;
    case 3:
        echo "Wednesday\n";
        break;
    case 4:
        echo "Thursday\n";
        break;
    case 5:
        echo "Friday\n";
        break;
    case 6:
    case 7:
        echo "Weekend\n";
        break;
    default:
        echo "Invalid day\n";
}

// Switch without break (fall-through)
$grade = 'B';

switch ($grade) {
    case 'A':
        echo "Excellent!\n";
        // Falls through to B
    case 'B':
        echo "Good job!\n";
        break;
    case 'C':
        echo "Fair\n";
        break;
    default:
        echo "Need improvement\n";
}

// Switch with multiple cases sharing same code
$fruit = 'apple';

switch ($fruit) {
    case 'apple':
    case 'pear':
        echo "This is a pome fruit\n";
        break;
    case 'peach':
    case 'plum':
        echo "This is a stone fruit\n";
        break;
    default:
        echo "Unknown fruit type\n";
}
?>