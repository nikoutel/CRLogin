<?php

/**
 *
 * error.php
 * Error page
 * 
 * 
 * @package CRLogin
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
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
} else {
    $error = '';
}
$str = <<<ERROR
    An error has occurred <br />\n
    Guru meditation:<br />\n<br />\n
    $error
    <br />\n<br />\n
ERROR;
echo $str;
if (isset($_SESSION['reinstall']) && ($_SESSION['reinstall'] === TRUE)){
    echo 'Please try to re-<a href = "install/index.php">install</a>';
        
}
session_destroy();
