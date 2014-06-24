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

$docRoot = $_SERVER['DOCUMENT_ROOT'];
$baseDir = realpath(dirname(__FILE__));
$subDir = str_replace($docRoot, '', $baseDir);
if (!defined('BASE_DIR')) define('BASE_DIR', $baseDir);
if (!defined('SUB_DIR')) define('SUB_DIR', $subDir);

if (isset($_GET['s'])) {
    switch (strtolower($_GET['s'])) {
        case 'login':
            include BASE_DIR . '/demo/login.php';
            break;
        case 'logout':
            //  js handles logout
            break;
        case 'members':
            include BASE_DIR . '/demo/members_area.php';
            break;
        case 'changepassword':
            include BASE_DIR . '/demo/changepassword.php';
            break;
        case 'register':
            include BASE_DIR . '/demo/register.php';
            break;
        default:
            include BASE_DIR . '/demo/main.php';
    }
} else {
    include BASE_DIR . '/demo/main.php';
}
?>
