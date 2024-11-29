<div style="margin:auto;width:900px;">
<a href="http://localhost/PHPFIRING/restaurant/category/insert.php">ADD DATA</a>
<?php 
require_once "../function.php";

if (isset($_GET['update'])) {
    $id=$_GET['update'];
    require_once "update.php";
}

if (isset($_GET['Delete'])) {
    $id=$_GET['Delete'];
    require_once "delete.php";
}

echo '<br>';

$sql = "SELECT idcategory FROM tblcategory";
$result = mysqli_query($connect,$sql);
$totaldata = mysqli_num_rows($result);
echo $totaldata;

$ammount= 3;

$pages = ceil($totaldata / $ammount);
for ($i=1; $i <= $pages; $i++) { 
    echo '<a href="?p='.$i.'">' .$i.'</a>';
    echo '&nbsp';
}
echo '<br> <br>';

if (isset($_GET['p'])) {
    $p=$_GET['p'];
    $start = ($p * $ammount) - $ammount;
}
else {
    $start= 0;

}
$sql = "SELECT * FROM tblcategory LIMIT $start,$ammount";
$result = mysqli_query($connect,$sql);
// var_dump($result);
$addition =mysqli_num_rows($result);
// echo '<br>';
// echo $addition;
echo '<table border="1px">
    <tr>
        <th>No</th>
        <th>Category</th>
        <th>Delete</th>
        <th>Change</th>
    </tr>';
$no=$start+1;
if ($addition>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'.$no++.'</td>';
        echo '<td>'.$row['category'].'</td>';
        echo '<td> <a href="?Delete='.$row['idcategory'].'">'.'Delete'.'</a></td>';
        echo '<td> <a href="?Change='.$row['idcategory'].'">'.'Change'.'</a></td>';
        echo '</tr>';
    }
}
echo '</table>';
?>


    <h1>restoooooo</h1>
</div>
