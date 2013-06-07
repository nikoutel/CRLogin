<?php
if (isset($_GET['s'])) {
    switch (strtolower($_GET['s'])) {
        case 'login':
            include 'demo/login.php';
            break;
        case 'logout':
          //  js handles logout
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
