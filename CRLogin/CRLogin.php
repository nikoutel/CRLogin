<?php

/**
 *
 * CRLogin: initialisation and controlling script
 *
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

use CRLogin\core\DIC;

class CRLogin
{
    /**
     * @var array
     */
    public static $l;

    /**
     * @var DIC
     */
    public static $dic;

    private static $session;

    /**
     * @param bool $isMembersArea
     * @param bool $logoutAction
     */
    public static function init($isMembersArea, $logoutAction) {

        /** define some paths */
        if (!defined('CRL_APP_DIR')) define('CRL_APP_DIR', 'CRLogin');
        if (!defined('CRL_BASE_DIR')) define('CRL_BASE_DIR', __DIR__);

        require_once CRL_BASE_DIR . '/CRLoginAutoloader.php';

        /** get the dependency injection container */
        if (!isset(self::$dic)) {
            self::$dic = new DIC;
        }

        /** get the configuration */
        if (!isset($genaralConfigArray)) {
            try {
                $genaralConfigArray = self::$dic->getConfiguration()->getGeneralConfigArray();
            } catch (\Exception $ex) {
                self::handleError($ex);
            }
        }
        /** define more paths ans URIs */
        if (!defined('CRL_BASE_URL')) define('CRL_BASE_URL', $genaralConfigArray['baseURL']);
        if (!defined('CRL_APP_URL_PATH')) define('CRL_APP_URL_PATH', $genaralConfigArray['appURLPath']);
        if (!defined('LOGIN_FORM_REQUEST_URI')) define('LOGIN_FORM_REQUEST_URI', $genaralConfigArray['loginFormReqURI']);
        if (!defined('LOGIN_SUCCESS_DEFAULT_URI')) define('LOGIN_SUCCESS_DEFAULT_URI', $genaralConfigArray['loginSuccessDefURI']);

        if (!isset(self::$l)) {
            try {
                self::$l = self::$dic->getLanguageFile();
            } catch (\Exception $ex) {
                self::handleError($ex);
            }
        }


        if (!isset(self::$session)) {
            try {
                self::$session = self::$dic->getSession();
            } catch (\Exception $ex) {
                self::handleError($ex);
            }
        }
        if (session_status() == PHP_SESSION_NONE) {
            try {
                self::$session->sessionStart();
            } catch (\Exception $ex) {
                self::handleError($ex);
            }
        }

        /** set the redirect URL */
        if (!self::isAjax()) {
            $_SESSION ['members'] = $isMembersArea;
            if (!isset($logoutAction) || !$logoutAction) {
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
        }
    }

    /**
     * Error handling function
     *
     * @param Exception $e
     */
    private static function handleError(\Exception $e) {
        require CRL_BASE_DIR . '/error.php';
    }

    /**
     * Checks if script is called through ajax
     *
     * @return bool
     */
    public static function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Returns a token used in the login-form
     *
     * @return string
     */
    public static function getToken() {
        try {
            $crypt = self::$dic->getObject('Crypt');
            $token = $crypt->getRandom('challenge');
            $_SESSION['token'] = $token;
        } catch (\Exception $e) {
            $token = '';
        }

        return $token;
    }

    /**
     * Logout
     *
     * @return mixed
     * @throws \Exception
     * @throws \ReflectionException
     */
    public static function CRLogout() {
        if (isset($_SESSION['logged']) && $_SESSION['logged']) {
            return self::$dic->getObject('logout')->executeAction();
        }
    }
}

CRLogin::init(isset($isMembersArea) ? $isMembersArea : false, isset($logoutAction) ? $logoutAction : false);