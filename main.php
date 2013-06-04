<?php
require 'public_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['MAIN_LINK'] ?></title>
        <link href="login.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
            <div id ="login">
                <?php
                if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
                    echo '<a href="index.php?s=login">'.$l['LOGIN_LINK'].'</a>';
                } else {
                    echo $l['HELLO'] . ' '. $_SESSION['username'];
                    echo ' | <a href="index.php?s=logout">'.$l['LOGOUT_LINK'].'</a>';
                }
                ?>
            </div><div id="top">

                <div id="content">
                    <h1><?php echo $l['DEMO_MAIN_H1'] ?></h1>
                    <p><?php echo $l['DEMO_MAIN_TXT'] ?></p>
                    <ul>
                        <li><a href="index.php?s=main"><?php echo $l['MAIN_LINK'] ?></a></li>
                        <li><a href="index.php?s=login"><?php echo $l['LOGIN_LINK'] ?></a></li>
                        <li><a href="index.php?s=members"><?php echo $l['MEMBERS_LINK'] ?></a></li>
                        
                    </ul>

                </div>
        </div>
    </body>
</html>
