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
if (!defined('CRL_APP_DIR')) define('CRL_APP_DIR', 'CRLogin');
if (!defined('CRL_BASE_DIR')) define('CRL_BASE_DIR', __DIR__);

if (!isAjax()) {
    if (!defined('LOGIN_FORM_REQUEST_URI')){
        exit("Error: LOGIN_FORM_REQUEST_URI not set!");
    }
    if (!defined('LOGIN_SUCCESS_DEFAULT_URI')) define('LOGIN_SUCCESS_DEFAULT_URI', '/');
}


require_once CRL_BASE_DIR . '/CRLoginAutoloader.php';

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

$genaralConfigArray = $dic->getConfiguration()->getGeneralConfigArray();
if (!defined('CRL_BASE_URL')) define('CRL_BASE_URL', $genaralConfigArray['baseURL']);
if (!defined('CRL_APP_URL_PATH')) define('CRL_APP_URL_PATH', $genaralConfigArray['appURLPath']);

if (!isAjax()) {
    if (!isset($isMembersArea)) {
        $isMembersArea = false;
    }
    $_SESSION ['members'] = $isMembersArea;
    if ($_SESSION ['members']) {
        $_SESSION['redirectURL'] = CRL_BASE_URL . $_SERVER['REQUEST_URI'];
        if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
            header('Location:' . LOGIN_FORM_REQUEST_URI);
            die();
        }
    } else {
        $redirectURL = CRL_BASE_URL . $_SERVER['REQUEST_URI'];
        if (strpos($redirectURL, LOGIN_FORM_REQUEST_URI) === false) {
            $_SESSION['redirectURL'] = $redirectURL;
        } else {
            if (!isset($_SESSION['redirectURL'])) {
                $_SESSION['redirectURL'] = LOGIN_SUCCESS_DEFAULT_URI;
            }
        }
    }
}
