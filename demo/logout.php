<?php
/**
 *
 * logout.php
 *
 * This is a TEMPORARY SCRIPT for demonstration and development purposes only
 *
 * @package CRLogin
 * @subpackage demo
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
/*
 * Prevents the direct access of this file
 */
if (count(get_included_files()) == 1) {
    header("location: /index.php?s=login");
    die();
}
$isMembersArea = false;
$logoutAction = true;
require   'CRLogin/CRLogin.php';
$return = CRLogout($dic);
if ($return['redirect']) {
    header("location: ". $return['redirectURL']);
}