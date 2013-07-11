<?php

/**
 *
 * index.php
 * A basic entry point.
 * 
 * 
 * @package CRLogin
 * @subpackage demo-views
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

if (isset($_GET['s'])) {
    switch (strtolower($_GET['s'])) {
        case 'login':
            include 'CRLogin/demo-views/login.php';
            break;
        case 'logout':
            //  js handles logout
            break;
        case 'members':
            include 'CRLogin/demo-views/members_area.php';
            break;
        case 'changepassword':
            include 'CRLogin/demo-views/changepassword.php';
            break;
        case 'register':
            include 'CRLogin/demo-views/register.php';
            break;
        default:
            include 'CRLogin/demo-views/main.php';
    }
} else {
    include 'CRLogin/demo-views/main.php';
}
?>
