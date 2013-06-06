<?php
require 'public_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['MAIN_LINK'] ?></title>
        <link href="login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>       
        <script type="text/javascript">
            if (typeof jQuery === 'undefined') {
                document.write(unescape("%3Cscript src='/scripts/jquery-1.7.1.min.js' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
        <script type="text/javascript" src="scripts/scripts.js"></script>
    </head>
    <body>

        <div id ="login">
            <?php
            if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
                echo '<a href="index.php?s=login">' . $l['LOGIN_LINK'] . '</a>';
            } else {
                echo $l['HELLO'] . ' ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES);
                echo ' | <a href="index.php?s=logout">' . $l['LOGOUT_LINK'] . '</a>';
            }
            ?>
        </div><div id="top">

            <div id="content">
                <h1><?php echo $l['DEMO_MAIN_H1'] ?></h1>
                <p><?php echo $l['DEMO_MAIN_TXT'] ?></p>
                <ul>
                    <li><a href="index.php?s=login"><?php echo $l['LOGIN_LINK'] ?></a></li>
                    <li><a href="index.php?s=members"><?php echo $l['MEMBERS_LINK'] ?></a></li>
                    <li><a href="index.php?s=register"><?php echo $l['REGISTER_LINK'] ?></a></li>

                </ul>

            </div>
        </div>
    </body>
</html>
