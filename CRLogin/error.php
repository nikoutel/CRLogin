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

$errormsg = $e->getMessage();
$errorCode = $e->getCode();

$showMsg = function() use ($errorCode) {$n=1; return($errorCode >> $n-1) & 1;};
$reinstall = function() use ($errorCode) {$n=2; return($errorCode >> $n-1) & 1;};
$errorLogged = function() use ($errorCode) {$n=3; return($errorCode >> $n-1) & 1;};
$breakAfterError = function() use ($errorCode) {$n=4; return($errorCode >> $n-1) & 1;};

if ($showMsg()) {
    $error = $errormsg;
} else {
    $error = '';
}

if ($errorLogged()) {
    $error .= '<br />(errors have been logged)';
}

$str = <<<ERROR
    Guru meditation:<br />\n<br />\n
    An error has occurred: <br />\n<br />\n
    
    $error
    <br />\n<br />\n
ERROR;
echo $str;

if ($reinstall()){
    echo 'Please try to re-<a href ="' . CRL_APP_DIR . '/install/index.php">install</a>';
        
}

if ($breakAfterError()) die();