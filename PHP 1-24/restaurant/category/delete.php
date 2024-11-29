<?php
require_once "../function.php";

$sql = "DELETE FROM tblcategory WHERE idcategory =$id";
$result = mysqli_query($connect,$sql);
header("location:http://localhost/PHPFIRING/restaurant/category/select.php")
?>