<?php

/**
 *
 * index.php
 * A basic entry point.
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

define('CRL_BASE_DIR', '.');
define('CRL_APP_DIR', 'CRLogin');
define('LOGIN_FORM_REQUEST_URI', '/index.php?s=login');
$isMembersArea = false;
require CRL_BASE_DIR . DIRECTORY_SEPARATOR . CRL_APP_DIR . DIRECTORY_SEPARATOR .'CRLogin.php';

if (isset($_GET['s'])) {
    switch (strtolower($_GET['s'])) {
        case 'login':
            include CRL_BASE_DIR . '/demo/login.php';
            break;
        case 'logout':
            //  js handles logout
            break;
        case 'members':
            include CRL_BASE_DIR . '/demo/members_area.php';
            break;
        case 'changepassword':
            include CRL_BASE_DIR . '/demo/changepassword.php';
            break;
        case 'register':
            include CRL_BASE_DIR . '/demo/register.php';
            break;
        default:
            include CRL_BASE_DIR . '/demo/main.php';
    }
} else {
    include CRL_BASE_DIR . '/demo/main.php';
}
?>
