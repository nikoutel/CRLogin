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

$isMembersArea = false;

if (isset($_GET['s'])) {
    switch (strtolower($_GET['s'])) {
        case 'login':
            include 'demo/login.php';
            break;
        case 'logout':
            //  js handles logout
            break;
        case 'members':
            include 'demo/members_area.php';
            break;
        case 'changepassword':
            include 'demo/changepassword.php';
            break;
        case 'register':
            include 'demo/register.php';
            break;
        case 'public':
            include 'demo/public.php';
            break;
        default:
            include 'demo/main.php';
    }
} else {
    include 'demo/main.php';
}
?>
