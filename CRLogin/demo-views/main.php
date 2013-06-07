<?php
if (count(get_included_files()) == 1) {
    header("location: /index.php?s=main");
    die();
}
$base = realpath($_SERVER["DOCUMENT_ROOT"]);
require $base . '/CRLogin/inc/public_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['MAIN_LINK'] ?></title>
        <link href="/CRLogin/demo-views/login.css" rel="stylesheet" type="text/css" />
        <?php require $base . '/CRLogin/inc/head.inc.php'; ?>
    </head>
    <body>

        <div id ="login">
            <a href="index.php?s=main">Main</a> | 
            <?php
            if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
                echo ' <a href="index.php?s=login">' . $l['LOGIN_LINK'] . '</a>';
            } else {
                echo $l['HELLO'] . ' ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES);
                echo ' | <a href="index.php?s=logout">' . $l['LOGOUT_LINK'] . '</a>';
            }
            ?>
        </div>
        <div id="top">

            <div id="content">
                <h1><?php echo $l['DEMO_MAIN_H1'] ?></h1>
                <p><?php echo $l['DEMO_MAIN_TXT'] ?></p>
                <ul>
                    <li><a href="index.php?s=login"><?php echo $l['LOGIN_LINK'] ?></a></li>
                    <li><a href="index.php?s=members"><?php echo $l['MEMBERS_LINK'] ?></a></li>
                    <li><a href="index.php?s=register"><?php echo $l['REGISTER_LINK'] ?></a></li>
                    <li><a href="index.php?s=changepassword"><?php echo $l['CHANGE_PASS_LINK'] ?></a></li>
                </ul>

            </div>
        </div>
    </body>
</html>
