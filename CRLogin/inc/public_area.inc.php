<?php

/**
 *
 * public_area.inc.inc
 * Include file to be included on top of all public area pages
 * 
 * 
 * @package CRLogin
 * @subpackage inc
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
use CRLogin\core\DIC;

require $base . '/CRLoginAutoloader.php';


$dic = new DIC;
$l = $dic->getLanguageFile();
$session = $dic->getSession();
$session->sessionStart();
$_SESSION ['members'] = FALSE;

$redirectURL = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; //@todo not safe
if (strpos($redirectURL, 's=login') === false) {
    $_SESSION['redirectURL'] = $redirectURL;
} else {
    if (!isset($_SESSION['redirectURL'])) {
        $_SESSION['redirectURL'] = 'index.php';
    }
}

function getToken($dic) {
    try {
        $crypt = $dic->getObject('Crypt');
        $token = $crypt->getRandom('challenge');
        $_SESSION['token'] = $token;
    } catch (\Exception $e) {
        $token = '';
    }

    return $token;
}

?>
