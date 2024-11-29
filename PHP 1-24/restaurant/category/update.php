update data
<?php
require_once "../function.php";
$sql = "SELECT * FROM tblcategory WHERE idcategory = $id";
$result = mysqli_query($connect,$sql);
$row=mysqli_fetch_assoc($result);
echo $row['category'];
// $category = 'firejuice';
// $id = 1;
// $sql = "UPDATE tblcategory SET category='$category'WHERE idcategory= $id ";
// $result = mysqli_query($connect,$sql);
// echo $sql
?>

<form action="" method="post">
    category : 
    <input type="text" name="category" value="<?php echo $row ['category'] ?>">
    <br>
    <input type="submit"name="save" value="save">
</form>

<?php
if (isset($_POST['save'])) {
    $category = $_POST['category'];
    $sql = "UPDATE tblcategory SET category='$category'WHERE idcategory= $id ";
    $result = mysqli_query($connect,$sql);
    header("location:http://localhost/PHPFIRING/restaurant/category/select.php");
}
?>