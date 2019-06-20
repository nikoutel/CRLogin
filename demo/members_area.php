<?php

/**
 *
 * members_area.php
 * A demonstration members area page 
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
    header("location: /index.php?s=members");
    die();
}

$isMembersArea = true;
require   'CRLogin/CRLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo CRLogin::$l['MEMBERS_LINK'] ?></title>
        <link href="demo/login.css" rel="stylesheet" type="text/css" />
        <?php require CRL_BASE_DIR .  '/inc/head.inc.php'; ?>
    </head>
    <body>

        <div id ="login">
            <a href="index.php?s=main">Main</a> | 
            <?php
            if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
                echo ' <a href="index.php?s=login">' . CRLogin::$l['LOGIN_LINK'] . '</a>';
            } else {
                echo CRLogin::$l['HELLO'] . ' ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES);
                echo ' | <a href="index.php?s=logout">' . CRLogin::$l['LOGOUT_LINK'] . '</a>';
            }
            ?>
        </div>
        <div id="top">

            <div id="content">
                <h1><?php echo CRLogin::$l['HELLO'] . ' ' . htmlspecialchars($_SESSION['username'], ENT_QUOTES) . '. ' . CRLogin::$l['DEMO_MEMBERS_H1'] ?></h1>
                <p><?php echo CRLogin::$l['DEMO_MEMBERS_TXT'] ?></p>
                <ul>
                    <li><a href="index.php?s=main"><?php echo CRLogin::$l['MAIN_LINK'] ?></a></li>
                    <li><a href="index.php?s=changepassword"><?php echo CRLogin::$l['CHANGE_PASS_LINK'] ?></a></li>
                    <li><a href="index.php?s=register"><?php echo CRLogin::$l['REGISTER_LINK'] ?></a></li>

                </ul>

            </div>
        </div>
    </body>
</html>