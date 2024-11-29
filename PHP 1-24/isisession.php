<?php
session_start();
echo $_SESSION['user'];
echo '<br>';
echo $_SESSION['fname'];
echo '<br>';
echo $_SESSION['address'];
echo '<br>';
foreach ($_SESSION as $key => $value) {
    echo $key.' => '.$value.'<br>';
}