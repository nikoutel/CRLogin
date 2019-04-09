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

if (!isAjax()) {
    if (!defined('CRL_BASE_DIR')){
        exit("Error: CRL_BASE_DIR not set!");
    }
    if (!defined('CRL_APP_DIR')){
        exit("Error: CRL_APP_DIR not set!");
    }
    if (!file_exists(CRL_BASE_DIR . DIRECTORY_SEPARATOR . CRL_APP_DIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php')) {
        exit("Error: CRL_BASE_DIR and/or CRL_APP_DIR not correctly set!");
    }
    if (!defined('LOGIN_FORM_REQUEST_URI')){
        exit("Error: LOGIN_FORM_REQUEST_URI not set!");
    }
} else {
    if (!defined('CRL_BASE_DIR')) define('CRL_BASE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/' . dirname(dirname($_SERVER['SCRIPT_NAME'])));
    if (!defined('CRL_APP_DIR')) define('CRL_APP_DIR', basename(dirname($_SERVER['SCRIPT_NAME'])));
}

$baseURL = dirname("//{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}");
if (!defined('CRL_BASE_URL')) define('CRL_BASE_URL', $baseURL);

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
            header('Location:' . LOGIN_FORM_REQUEST_URI);
            die();
        }
    } else {
        $redirectURL = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; //@todo not safe
        if (strpos($redirectURL, LOGIN_FORM_REQUEST_URI) === false) {
            $_SESSION['redirectURL'] = $redirectURL;
        } else {
            if (!isset($_SESSION['redirectURL'])) {
                $_SESSION['redirectURL'] = '/';
            }
        }
    }
}
