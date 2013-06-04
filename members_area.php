<?php
require 'members_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['MEMBERS_LINK'] ?></title>
        <link href="login.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
            <div id ="login">
                <?php
                if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
                    echo '<a href="index.php?s=login">Login</a>';
                } else {
                    echo $l['HELLO'] . ' '. $_SESSION['username'];
                    echo ' | <a href="index.php?s=logout">Logout</a>';
                }
                ?>
            </div><div id="top">

                <div id="content">
                    <h1><?php echo $l['HELLO'] . ' '. $_SESSION['username'] . '. ' . $l['DEMO_MEMBERS_H1'] ?></h1>
                    <p><?php echo $l['DEMO_MEMBERS_TXT'] ?></p>
                    <ul>
                        <li><a href="index.php?s=main"><?php echo $l['MAIN_LINK'] ?></a></li>
                        <li><a href="index.php?s=changepassword"><?php echo $l['CHANGE_PASS_LINK'] ?></a></li>
                        
                    </ul>

                </div>
        </div>
    </body>
</html>