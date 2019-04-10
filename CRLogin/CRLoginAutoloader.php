<?php

/**
 *
 * CRLoginAutoloader.php
 * Autoloader for CRLogin
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

function CRLoginAutoloader($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    $fileName = explode(DIRECTORY_SEPARATOR, $fileName);
    $basedir = array_shift($fileName);
    $fileName = implode(DIRECTORY_SEPARATOR, $fileName);

    if (true === file_exists($fileName) && is_file($fileName)) {
        require_once($fileName);
        return true;
    } elseif (true === file_exists(__DIR__.  DIRECTORY_SEPARATOR . $fileName) && is_file(__DIR__.  DIRECTORY_SEPARATOR . $fileName)) {
        require_once(__DIR__. DIRECTORY_SEPARATOR .  $fileName);
        return true;
    }
}

spl_autoload_register('CRLoginAutoloader');
?>
