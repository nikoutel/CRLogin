<?php
/**
 *
 * This is a TEMPORARY SCRIPT. Its just a quick install solution.
 * A new, more dynamic and configurable application is on its way.
 * 
 * 
 * @package CRLogin
 * @subpackage install
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
ini_set('display_errors', 0);
session_start();

if (!isset($_SESSION['requirementsTrue']) || $_SESSION['requirementsTrue'] === FALSE) {
    header("Location:index.php");
    die();
}
if (!isset($_SESSION['done'])) {
    $_SESSION['done'] = FALSE;
}
$done = $_SESSION['done'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=100" /> <!--Tell Internet Explorer to use the highest compatibility mode, i.e not IE7 -->
        <title>CRLogin installation</title>

        <link href="install.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">
            if (typeof jQuery == 'undefined') {
                document.write(unescape("%3Cscript src='../scripts/jquery-1.7.1.min.js' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
        <script type="text/javascript" src="scripts/install_scripts.js"></script>
    </head>
    <body>
        <div id="container" class="">
            <div id="formdiv">
                <div class="text">
                    <h1 class="secheader">CRLogin installation</h1>
                    <h2>Configuration</h2>
                    <p>You have everything you need! Now, enter your database connection details and the URL/path data below.</p>
                </div>
                <form action="install_request.php?action=form" method="post">
                    <table id="installformt" border="0">

                        <tbody>
                            <tr>
                                <td>
                                    <b>Database admin username:</b>
                                    <br />
                                    An account with permissions to create the database and the user needed.
                                    This  will be used only for the installation.
                                </td>
                                <td><input name="rootuser" id="rootuser" value="root" type="text" /></td>
                                <td id="rootusermsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Database admin password:</b>
                                    <br />
                                    Password for the MySQL database administrator.
                                </td>
                                <td><input name="rootpass" id="rootpass" type="password" /></td>
                                <td id="rootpassmsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Database server hostname:</b> 
                                    <br />
                                    The hostname or IP address of the MySQL database server.
                                    This is usually "localhost". 
                                </td>
                                <td><input name="host" id="host" value="localhost" type="text" /></td>
                                <td id="hostmsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Database server port:</b>
                                    <br />
                                    The port MySQL is running on.
                                </td>
                                <td><input name="port" id="port" value="3306" type="text" /></td>
                                <td id="portmsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Database name:</b>
                                    <br />
                                    The name of the database you want to use.
                                    If it does not exist it will be created.
                                </td>
                                <td><input name="database_name" id="database_name" type="text" /></td>
                                <td id="database_namemsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Username:</b>
                                    <br />
                                    The username for the mysql account that CRLogin will  use.
                                    If the user account does not yet exist, it will be  created.
                                </td>
                                <td><input name="user" id="user" type="text" /></td>
                                <td id="usermsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Password:</b>
                                    <br />
                                    The password for the user account.
                                </td>
                                <td><input name="userpass" id="userpass" type="password" /></td>
                                <td id="userpassmsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Login form:</b>
                                    <br />
                                    The URL of the login form.<br/>
                                    (e.g. https://example.com/myapp/index.php?s=login)
                                </td>
                                <td><input name="loginform" id="loginform" type="text" /></td>
                                <td id="loginformmsg"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Succes redirect:</b>
                                    <br />
                                    The URL for the successful login redirect. <br/>
                                    (e.g. https://example.com/myapp/welcome/)
                                </td>
                                <td><input name="successredirect" id="successredirect" type="text" /></td>
                                <td id="successredirectmsg"></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <input name="inform" value="inform" type="hidden" id="inform" /> 
                    <input value="Install" type="submit" id="forma" />    

                </form>

                <div id ="wait" ></div>
                <div id ="msg" class="green">
<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
                </div>
                <div id ="errormsg" class="red">
<?php
$noError = TRUE;
if (isset($_SESSION['errormsg'])) {
    echo $_SESSION['errormsg'];
    unset($_SESSION['errormsg']);
    $noError = FALSE;
}
?>
                </div>
                <div id="returnlink">
<?php
if ($noError && $done) {
    echo ' The installation is complete <br />';
    echo 'Please delete the install folder before continuing<br />';
    echo 'A demo account has been created:<br />';
    echo 'username: <b>user</b>,  password: <b>crlogin</b><br />';
    echo 'You should change the password after <a href="' . $_SESSION['loginFormReqURI'] . '">login</a><br />';
    unset($_SESSION['done']);
    if (isset($_SESSION['returnScript'])) {

        $uri = $_SERVER['HTTP_HOST'] . $_SESSION['returnScript'];

        echo '<a href = "http://' . $uri . '">Return to ' . $uri . '</a>';
    }
}
?>  
                </div>
            </div>
        </div>
    </body>
</html>