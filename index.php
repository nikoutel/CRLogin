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
        default:
            include 'login.php';
    }
} else {
    include 'login.php';
}
?>
