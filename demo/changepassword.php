<?php
/**
 *
 * changepassword.php
 * A demonstration change password form.
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
    header("location: /index.php?s=changepassword");
    die();
}

$isMembersArea = true;
require   'CRLogin/CRLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo CRLogin::$l['CHANGE_PASS_LINK'] ?></title>
        <link href="demo/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>       
<?php require CRL_BASE_DIR . '/inc/head.inc.php'; ?>
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
            <div id="noscript">
<?php echo CRLogin::$l['NO_SCRIPT'] ?>
            </div>

            <div id="lgerror"></div> 
            <div id="changemsg"></div> 

            <form action="" method="post" id="change">
                <fieldset ><br /><br /> 
                    <table>
                        <tr>
                            <td><label for="oldpass"><?php echo CRLogin::$l['OLD_PASS'] ?>:</label></td>
                            <td><input type="password" name="crl_oldpass" class="crl_oldpass" id="oldpass"/></td>
                            <td id="oldpasserror" class="error"></td>
                        </tr>
                        <tr>
                            <td><label for="newpass"><?php echo CRLogin::$l['NEW_PASS'] ?>:</label></td>
                            <td><input type="password" name="newpass" class="crl_newpass" id="newpass"/></td>
                            <td><span id="newpasserror"  class="error"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><span id="passstr"> <?php echo CRLogin::$l['PASS_FORMAT_MSG'] ?> </span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label for="newpass2"><?php echo CRLogin::$l['NEW_PASS_2'] ?>:</label></td>
                            <td><input type="password" name="newpass2" class="crl_newpass2" id="newpass2"/></td>
                            <td id="newpasserror2"  class="error"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="hidden" name="username" class="crl_username" id="username" value="<?php echo $_SESSION['username'] ?>"/></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="hidden" name="token" class="nkod" id="crl_token" value="<?php echo CRLogin::getToken() ?>"/></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label for="changesubmit"></label></td>
                            <td><input type="submit" name="changesubmit" value="<?php echo CRLogin::$l['CHANGE_PASS'] ?>" class="changesubmit" id="changesubmit"/></td>
                            <td></td>
                        </tr>
                    </table>
                </fieldset>	
            </form>
            <div id="msg" ></div>
        </div>
    </body>
</html>
