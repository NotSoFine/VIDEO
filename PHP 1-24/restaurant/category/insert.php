<form action="">
    category:
    <input type="text" name="category">
    <br>
    <input type="submit" name="save" value="save">
</form> 

<?php 
require_once "../function.php";
if (isset($_POST['save'])) {
    $category = $_POST['save'];
    echo $category;
    $category = 'iced mango';
    $sql = "INSERT INTO tblcategory VALUES ('','$category')";
    $result = mysqli_query($connect,$sql);
    header("location:http://localhost/PHPFIRING/restaurant/category/select.php");
}

?>
