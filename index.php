<?php
if (isset($_GET['s'])) {
    switch (strtolower($_GET['s'])) {
        case 'login':
            include 'CRLogin/demo-views/login.php';
            break;
        case 'logout':
          //  js handles logout
            break;
        case 'members':
            include 'CRLogin/demo-views/members_area.php';
            break;
        case 'changepassword':
            include 'CRLogin/demo-views/changepassword.php';
            break;
        case 'register':
            include 'CRLogin/demo-views/register.php';
            break;
        default:
            include 'CRLogin/demo-views/main.php';
    }
} else {
    include 'CRLogin/demo-views/main.php';
}
?>
