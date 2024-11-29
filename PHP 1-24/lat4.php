<?php
// MATH OP
$a = 2;
$b = 2;
$c = $a + $b;
echo $c.'<br>';

$c = $a - $b;
echo $c.'<br>'; 

$c = $a * $b;
echo $c.'<br>';

$c = $a / $b;
echo floor($c).'<br>';

$c = $a % $b;
echo $c.'<br>';

//LOGIC MATH OP
$c = $a < $b;
echo $c;

$c = $a > $b;
echo $c;

$c = $a == $b;
echo $c;

$c = $a != $b;
echo $c.'<br>';

//INCREMENT MATH OP
$a--;
echo $a.'<br>';

//STRING OP
$f= 'hi,';
$s= 'there';
$greet= $f.$s;
$greet .= 'something good?';
echo $greet;

?>