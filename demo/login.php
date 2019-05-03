<?php
/**
 *
 * login.php
 * A demonstration login form 
 *
 * This is a TEMPORARY SCRIPT for demonstration and development purposes only
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
    header("location: /index.php?s=login");
    die();
}
$isMembersArea = false;
require CRL_BASE_DIR . '/CRLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $l['LOGIN_LINK'] ?></title>
        <link href="demo/login.css" rel="stylesheet" type="text/css" />
<?php require CRL_BASE_DIR .  '/inc/head.inc.php'; ?>
    </head>
    <body>
        <div id="top">

            <div id="noscript">
<?php echo $l['NO_SCRIPT'] ?> 
            </div>

            <div id="lgerror"></div> 
            <form action="" method="post" id="lg">
                <fieldset ><br /><br />
                    <label for="username"><?php echo $l['USERNAME'] ?>:</label> 
                    <input type="text" name="username" class="txt" id="username"/><br />
                    <label for="password"><?php echo $l['PASSWORD'] ?>:</label> 
                    <input type="password" name="password" class="txt" id="password"/><br />	
                    <input type="hidden" name="token" id="token" value="<?php echo getToken($dic) ?>"/><br />
                    <label for="lgsubmit"></label>	
                    <input type="submit" name="submit" value="<?php echo $l['LOGIN'] ?>" class="subm" id="lgsubmit" disabled="disabled"/>
                </fieldset>	
            </form>
            <div id="msg" ></div>
        </div>
    </body>
</html>
