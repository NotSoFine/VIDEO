<?php
// $who = array('me','him','her',100);
// var_dump($who);
// echo '<br>';
// foreach ($who as $key) {
//         echo $key.'<br>';
// }

$person = array(
    "jey" => "bested",
    "wat" => "whiteguy",
    "zay" => "coolguy"
);
var_dump($person);
echo '<br>';
foreach ($person as $key => $value) {
    echo $key.'-'.$value;
    echo '<br>';
}
?>