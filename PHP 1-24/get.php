<form action="" method="get">
    name:
    <input type="text" name="name">
    address:
    <input type="text" name="address">
    <input type="submit" name="submit" value="save">
</form>

<?php
if (isset($_GET['submit'])) {
    $name = $_GET['name'];
    $address = $_GET['address'];

    echo $name;
    echo '<br>';
    echo $address;
}

?>