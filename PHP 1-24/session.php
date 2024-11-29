<nav>
    <ul>
        <li><a href="?menu-contents">contents</a></li>
        <li><a href="?menu-delete">delete</a></li>
        <li><a href="?menu-destroy">destroy</a></li>
    </ul>
</nav>
<?php
session_start();

if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];

    echo $menu;

    switch ($menu) {
        case 'contents':
            isisesson();
            break;
        case 'delete':
            unset($_SESSION['user']);
            break;
        case 'destroy':
            session_destroy();
            break;

        default:
            # code...
            break;
    }
}

//var_dump($_SESSION);

function isisesson(){

    $_SESSION['user']='julya';

    $_SESSION['fname']='julya nym';

    $_SESSION['address']='northern erikase 2493';
    
}