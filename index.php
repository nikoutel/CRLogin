<?php
if (isset($_GET['s'])) {
    switch (strtolower($_GET['s'])) {
        case 'login':
            include 'login.php';
            break;
        case 'logout':
            include 'logout.php';
            break;
        case 'members':
            include 'members_area.php';
            break;
        case 'changepassword':
            include 'changepassword.php';
            break;
        case 'register':
            include 'register.php';
            break;
        default:
            include 'main.php';
    }
} else {
    include 'main.php';
}
?>
