<?php

/**
 *
 * main.php
 * A demonstration public area page 
 * 
 * This is a TEMPORARY SCRIPT for demonstration and development purposes only
 * 
 * @package CRLogin
 * @subpackage demo
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013-2019 Nikos Koutelidis
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
    header("location: /index.php?s=main");
    die();
}
$isMembersArea = false;
require   'CRLogin/CRLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['MAIN_LINK'] ?></title>
        <link href="demo/login.css" rel="stylesheet" type="text/css" />
        <?php require CRL_BASE_DIR .  '/inc/head.inc.php'; ?>
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
