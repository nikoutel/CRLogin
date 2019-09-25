<?php
/**
 *
 * msg.js.php
 * Include file to be included in the <head> section
 * Language array injection to js
 *
 * @package CRLogin
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

namespace CRLogin;

use CRLogin;

header('Content-Type: application/javascript');
$src = true;
require '../CRLogin.php';
?>
var l = <?php echo json_encode(CRLogin::$l); ?>;