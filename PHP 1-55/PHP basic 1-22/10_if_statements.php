<?php
// Basic if statement
$age = 18;

if ($age >= 18) {
    echo "You are an adult\n";
}

// if-else statement
$time = 14; // 24-hour format

if ($time < 12) {
    echo "Good morning!\n";
} else {
    echo "Good afternoon/evening!\n";
}

// if-elseif-else statement
$score = 85;

if ($score >= 90) {
    echo "Grade: A\n";
} elseif ($score >= 80) {
    echo "Grade: B\n";
} elseif ($score >= 70) {
    echo "Grade: C\n";
} else {
    echo "Grade: F\n";
}

// Nested if statements
$age = 25;
$hasLicense = true;

if ($age >= 18) {
    if ($hasLicense) {
        echo "You can drive\n";
    } else {
        echo "You need to get a license\n";
    }
} else {
    echo "You are too young to drive\n";
}

// Alternative syntax with : and endif
if ($age >= 21):
    echo "You can drink in the US\n";
else:
    echo "You cannot drink in the US\n";
endif;
?>