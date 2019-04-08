<?php

use CRLogin\core\DIC;

if (!function_exists('isAjax')) {
    function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}

if (!function_exists('getToken')) {
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
}

//@todo test CRL_BASE_DIR with call; if not ajax

$baseURL = dirname("//{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}");
if (!defined('CRL_BASE_URL'))define('CRL_BASE_URL', $baseURL);

if (!defined('CRL_BASE_DIR')) define('CRL_BASE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/' . dirname(dirname($_SERVER['SCRIPT_NAME'])));
if (!defined('CRL_APP_DIR')) define('CRL_APP_DIR', basename(dirname($_SERVER['SCRIPT_NAME'])));
require_once CRL_BASE_DIR . '/' . CRL_APP_DIR . '/CRLoginAutoloader.php';

if (!isset($dic)) {
    $dic = new DIC;
}
if (!isset($l)) {
    $l = $dic->getLanguageFile();
}
if (!isset($session)) {
    $session = $dic->getSession();
}
if (session_status() == PHP_SESSION_NONE) {
    $session->sessionStart();
}

if (!isAjax()) {
    if (!isset($isMembersArea)) {
        $isMembersArea = false;
    }
    $_SESSION ['members'] = $isMembersArea;
    if ($_SESSION ['members']) {
        $_SESSION['redirectURL'] = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; //@todo not safe
        if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
        header('Location:index.php?s=login'); //@todo decouple from demo
            die();
        }
    } else {
        $redirectURL = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; //@todo not safe
        if (strpos($redirectURL, 's=login') === false) { //@todo decouple from demo
            $_SESSION['redirectURL'] = $redirectURL;
        } else {
            if (!isset($_SESSION['redirectURL'])) {
                $_SESSION['redirectURL'] = 'index.php';
            }
        }
    }
}
if (!function_exists('getToken')) {
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
}
