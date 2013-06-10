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
session_start();
ini_set('display_errors', 0);

if ($_SERVER['QUERY_STRING'] == '') {
    $installScriptName = basename(__FILE__);
} else {
    $installScriptName = basename(__FILE__) . '?' . $_SERVER['QUERY_STRING'];
}
$_SESSION['installScriptName'] = $installScriptName;

if ((!isset($_GET['s'])) || ($_GET['s'] !== 'form')) {

    include 'install.php';
} else {
    include 'install_form.php';
}
?>
