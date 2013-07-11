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
if (isset($_POST['lang'])) {
    session_start();
    $_SESSION['lang'] = $_POST['lang'];
}
if (isset($_POST['db'])) {
    switch ($_POST['db']) {
        case 'mysql':
            include 'install_form_mysql.php';
            break;
        case 'sqlite3':
            include 'install_form_sqlite3.php';
            break;
        default:
            break;
    }
}
?>
