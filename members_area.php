<?php
require 'members_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['MEMBERS_LINK'] ?></title>
        <link href="login.css" rel="stylesheet" type="text/css" />
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
                echo '<a href="index.php?s=login">Login</a>';
            } else {
                echo $l['HELLO'] . ' ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES);
                echo ' | <a href="index.php?s=logout">Logout</a>';
            }
            ?>
        </div><div id="top">

            <div id="content">
                <h1><?php echo $l['HELLO'] . ' ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES) . '. ' . $l['DEMO_MEMBERS_H1'] ?></h1>
                <p><?php echo $l['DEMO_MEMBERS_TXT'] ?></p>
                <ul>
                    <li><a href="index.php?s=main"><?php echo $l['MAIN_LINK'] ?></a></li>
                    <li><a href="index.php?s=changepassword"><?php echo $l['CHANGE_PASS_LINK'] ?></a></li>
                    <li><a href="index.php?s=register"><?php echo $l['REGISTER_LINK'] ?></a></li>

                </ul>

            </div>
        </div>
    </body>
</html>