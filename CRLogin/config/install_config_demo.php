<?php

/**
 *
 * install_config_demo.php
 * Demo of the configuration file created by the installation process
 *
 *
 * @package CRLogin
 * @subpackage config
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

use CRLogin\DataAccess\DatabaseDrivers;

$db_config = array(
    'db' => array(
        'databaseDriver' => DatabaseDrivers::MySQL,
        'host' => 'localhost',
        'dbName' => 'logindb',
        'username' => 'rootuser',
        'password' => 'pass',
        'port' => '3306',
        'dbOptions' => array(
        )
    ),
    'general' => array(
        'language' => 'en',
        'installUniqueId' => '3u2Sok4VePf5e6SQ5kHXkQ', // CHANGE THIS
        'baseURL' => '//example.com:8080',
        'appURLPath' => '/lib/nikoutel/CRLogin/',
        'loginFormReqURI' => '/index.php?s=login',
        'loginSuccessDefURI' => '/index.php?s=main'
    )
);

/*

$db_config = array(
    'db' => array(
        'databaseDriver' => DatabaseDrivers::SQLite,
        'dbPath' => '/path/to/sqlite/db.sq3',
        'username' => NULL,
        'password' => NULL,
        'dbOptions' => array(
        )
    ),
    'general' => array(
        'language' => 'en',
        'installUniqueId' => '3u2Sok4VePf5e6SQ5kHXkQ', // CHANGE THIS
        'baseURL' => '//example.com:8080',
        'appURLPath' => '/lib/nikoutel/CRLogin/',
        'loginFormReqURI' => '/index.php?s=login',
        'loginSuccessDefURI' => '/index.php?s=main'
    )
);
 
 */
return $db_config;
?>
