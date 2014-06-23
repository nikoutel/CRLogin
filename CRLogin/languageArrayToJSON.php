<?php

/**
 *
 * languageArrayToJSON.php
 * Returns the language array in JSON format to an ajax call
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

namespace CRLogin;

use CRLogin\core\DIC;

if (!defined('BASE_DIR')) define('BASE_DIR', dirname(__FILE__).'/..');
require '../CRLoginAutoloader.php';

$dic = new DIC;
$l = $dic->getLanguageFile();
header('Content-Type: application/json');
echo json_encode($l);
?>
