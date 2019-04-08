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

/*
 * Prevents the direct access of this file 
 */
if (count(get_included_files()) == 1) {
    header("HTTP/1.1 404 Not Found", 404);
    die();
}
/*
 * Requirements
 */
$dir = realpath(dirname(__FILE__) . '/../config'); // consider putting this outside your document root for security
$basedir = basename(realpath(dirname(__FILE__) . '/../config'));
$file = 'install_config.php';
$requirements = array(
    'phpMinVersion' => '5.4.0',
    'configFileBase' => $basedir . DIRECTORY_SEPARATOR . $file,
    'configFile' => $dir . DIRECTORY_SEPARATOR . $file,
    'dbExtension' => array(
        'mysqlExtension' => 'mysql',
        'mysqliExtension' => 'mysqli',
        'pdomysqlExtension' => 'pdo_mysql',
        'sqliteExtension' => 'sqlite3'
    )
);
?>
