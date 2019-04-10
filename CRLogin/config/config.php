<?php

/**
 *
 * config.php
 * Main configuration file
 *
 *
 * @package CRLogin
 * @subpackage config
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

$config = array(
    'general' => array(
        'disabled' => 'FALSE', // kill switch
        'datastore' => 'database',
        'dbConfigFile' => CRL_BASE_DIR . '/' . CRL_APP_DIR . '/config/install_config.php',
        'challengeTimedelay' => 15, //number of seconds the challenge is stored in the database
        'sessionInDataStore' => TRUE,
        'cryptCostParameter' => '10'
    ),
    'db' => array(
        'dbOptions' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    )
);
return $config;
?>
