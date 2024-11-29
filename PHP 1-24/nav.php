<nav>
    <ul>
        <li><a href="?menu=identity">identity</a></li>
        <li><a href="?menu=history">history</a></li>
        <li><a href="?menu=role">role</a></li>
    </ul>
</nav>
<?php
if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
    require_once $menu.'.php';
}
?>