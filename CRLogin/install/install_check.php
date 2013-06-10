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
function configExists($configFile) {

    if (file_exists($configFile)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Checks if the configuration file is writable
 * 
 * @param string $configFile
 * @return boolean
 */
function configWritable($configFile) {

    if (is_writable($configFile)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Checks if a database extension is available
 * 
 * @param string $dbExtension
 * @return boolean
 */
function dbAvailable($dbExtension) {

    if (extension_loaded($dbExtension)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Checks if the version of PHP is sufficient
 * 
 * @param string $phpMinVersion
 * @return boolean
 */
function phpVersionCheck($phpMinVersion) {

    if (version_compare(PHP_VERSION, $phpMinVersion) >= 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

?>
