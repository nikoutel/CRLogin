<?php

/**
 *
 * members_area.php
 * A demonstration members area page 
 * 
 * 
 * @package CRLogin
 * @subpackage demo
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013 Nikos Koutelidis 
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin 
 * 
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 */

/*
 * Prevents the direct access of this file 
 */
if (count(get_included_files()) == 1) {
    header("location: /index.php?s=members");
    die();
}
require BASE_DIR . '/CRLogin/inc/members_area.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['MEMBERS_LINK'] ?></title>
        <link href="CRLogin/demo/login.css" rel="stylesheet" type="text/css" />
        <?php require BASE_DIR . '/CRLogin/inc/head.inc.php'; ?>
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