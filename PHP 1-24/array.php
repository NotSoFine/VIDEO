<?php
//dimensional array
// $member = array("one","two","three","for",100,2.5);
// var_dump($member);
// echo '<br>';
// echo $member[5];
// echo '<br>';

//for call
// for ($i=0; $i < 6; $i++) { 
//     //echo $i;
//     echo $member[$i].'<br>';
// }

//foreach call 
// foreach ($member as $key) {
//     echo $key.'<br>';
// }

//associative array
//1st assigning form
//
// $clients = array(
//     "client1" => "from SA",
//     "client2" => "from DP",
//     "client3" => "from LA",
//     "client4" => "from SF"
// );

//2nd assigning form
$clients["client1"]="San andres";
$clients["client2"]="Don pollo";
$clients["client3"]="Los angles";
$clients["client4"]="San freako";
$clients["client5"]="Boeing special";

//printing
var_dump($clients);
echo '<br>';
//echo $clients["client1"];
foreach ($clients as $key => $value) {
    echo $key." => ".$value;
    echo "<br>";
}

?>