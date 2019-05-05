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

/*
 * Prevents the direct access of this file 
 */
if (count(get_included_files()) == 1) {
    header("Location:index.php");
    die();
}

ini_set('display_errors', 0);
require 'install_check.php';
require 'install_requirements.php';
session_start();

if (!isset($_SESSION['errormsgconf'])) {
    $_SESSION['errormsgconf'] = '';
}
$requirementsTrue = TRUE;

/*
 * PHP version check
 */
$phpMinVersion = $requirements['phpMinVersion'];
$phpVersionTxt = 'Required PHP version >= ' . $phpMinVersion;
if (phpVersionCheck($phpMinVersion)) {
    $phpVersionCheck = array(
        'flag' => 'OK',
        'msg' => 'Your version: ' . PHP_VERSION,
        'cssClass' => 'greenb',
    );
} else {
    $phpVersion_msg = 'You need at least PHP version ' . $phpMinVersion;
    $phpVersion_msg .= '<br />Your version is ' . PHP_VERSION;
    $phpVersionCheck = array(
        'flag' => 'NOT OK',
        'msg' => $phpVersion_msg,
        'cssClass' => 'redb',
    );
    $requirementsTrue = FALSE;
}
/*
 * Javascript text messages
 */
$jsEnabledTxt = 'Javascript';
$jsEnabledCheck = 'Please enable your Javascript';
/*
 * Check if configuration file exists
 */
$configFile = $requirements['configFile'];
$configFileBase = $requirements['configFileBase'];
$configFileTxt = 'Configurations file ';
if (configExists($configFile)) {
    $configExists = array(
        'flag' => 'OK',
        'msg' => 'File is available',
        'cssClass' => 'greenb',
    );
    $_SESSION['configFile'] = $configFile;
} else {
    if (isset($_SESSION['errormsgconf']) && $_SESSION['errormsgconf'] == '') {
        $configExists_msg = '<div id="creates" >';
        $configExists_msg .= '<form action="install_request.php?action=create" method="post">';
        $configExists_msg .= 'The file <i>' . $configFileBase . '</i> does not exist. ';
        $configExists_msg .= '<input type="hidden" value="' . $configFile . '" name="filename" id="filename"/>';
        $configExists_msg .= '<input name="inform" value="inform" type="hidden" id="inform" /> ';
        $configExists_msg .= '<input type="submit" value="create"  id="create" />';
        $configExists_msg .= '</form>';
        $configExists_msg .= '</div>';
    } else {
        $configExists_msg = $_SESSION['errormsgconf'];
        $_SESSION['errormsgconf'] = '';
    }
    $configExists = array(
        'flag' => 'NOT OK',
        'msg' => $configExists_msg,
        'cssClass' => 'redb',
    );
    $requirementsTrue = FALSE;
}

/*
 * Check if configuration file is writable
 */
$configFileWritableTxt = 'Configurations file writable';
if (configWritable($configFile)) {
    $configWritable = array(
        'flag' => 'OK',
        'msg' => 'File is writable',
        'cssClass' => 'greenb',
    );
} else {
    $configWritable = array(
        'flag' => 'NOT OK',
        'msg' => 'Change the permissions on the file <i>' . $configFile . '</i><br /> to make it writable',
        'cssClass' => 'redb',
    );
    $requirementsTrue = FALSE;
}

/*
 * Check if database is available
 */
$dbExtension = $requirements['dbExtension'];
$dbExtensionTxt = 'Database support';
$dbChooseTxt = 'Choose a database';
$dbmsg = '';
$dbflag = FALSE;
$dbotions .= '';
foreach ($dbExtension as $key => $value) {
    if (dbAvailable($value)) {
        $dbmsg .= $value . ' is available<br />';
        $dbotions .= '<option>' . $value . '</option>';
        $dbflag = TRUE;
    } else {
        $dbflag = $dbflag OR FALSE;
    }
}

if ($dbflag) {
    $dbAvailable = array(
        'flag' => 'OK',
        'msg' => $dbmsg,
        'cssClass' => 'greenb',
    );
} else {
    $dbAvailable = array(
        'flag' => 'NOT OK',
        'msg' => 'You must have support for a database ',
        'cssClass' => 'redb',
    );
    $dbotions .= '<option>--</option>';
    $requirementsTrue = FALSE;
}


$isDisabled = '';
if (!$requirementsTrue) {
    $isDisabled = 'disabled="disabled"';
} else {
    $_SESSION['requirementsTrue'] = $requirementsTrue;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=100" />
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
                    <h1>CRLogin installation</h1>

                    <h2>Language</h2>
                    <p>Choose the language for the login interface.
                        (Unfortunately the installation process is at this point only in English ) </p><br />
                    <select name="lang" id="lang">
                        <option  value="en">English</option>
                        <option value="de">Deutsch</option>
                    </select>
                    <br />
                    <br />
                    <h2>Pre-Installation checks</h2>
                    <p>Checks are done to ensure that you are able to install and run 'CRLogin'.</p>
                </div>
                <table id="check">
                    <tbody>
                        <tr>
                            <td><?php echo $phpVersionTxt ?></td>
                            <td>
                                <span class="<?php echo $phpVersionCheck['cssClass'] ?>">
<?php echo $phpVersionCheck['flag'] ?>
                                </span>
                            </td>
                            <td><?php echo $phpVersionCheck['msg'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $jsEnabledTxt ?></td>
                            <td>
                                <span class="redb" id="jsEnabled">
                                    NOT OK
                                </span>
                            </td>
                            <td><span id="jsEnabledMsg"><?php echo $jsEnabledCheck ?></span></td>
                        </tr>
                        <tr>
                            <td><?php echo $configFileTxt ?></td>
                            <td>
                                <span class="<?php echo $configExists['cssClass'] ?>">
<?php echo $configExists['flag'] ?>
                                </span>
                            </td>
                            <td><?php echo $configExists['msg'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $configFileWritableTxt ?></td>
                            <td>
                                <span class="<?php echo $configWritable['cssClass'] ?>">
<?php echo $configWritable['flag'] ?>
                                </span>                    
                            </td>
                            <td><?php echo $configWritable['msg'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $dbExtensionTxt ?></td>
                            <td>
                                <span class="<?php echo $dbAvailable['cssClass'] ?>">
<?php echo $dbAvailable['flag'] ?>
                                </span>                  
                            </td>
                            <td><?php echo $dbAvailable['msg'] ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $dbChooseTxt ?></td>
                            <td>
                                <select name="choosedb" id ="choosedb">
<?php echo $dbotions ?>
                                </select>
                            </td>
                            <td><span id="choosedbmsg" class="yellow"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form action="<?php echo $installScriptName ?>?s=form" method="post" id="nexts">
            <br />
            <input type="submit" value="Next"  id="next" <?php echo $isDisabled ?>/>
        </form>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </body>
</html>