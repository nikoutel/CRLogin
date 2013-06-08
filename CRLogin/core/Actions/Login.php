<?php

/**
 *
 * Login: Executes and controls the 'login' action
 * 
 * 
 * @package CRLogin
 * @subpackage core/Actions
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

namespace CRLogin\core\Actions;

use CRLogin\core\User;
use CRLogin\core\Challenge;
use CRLogin\core\Response;
use CRLogin\core\Authentication;
use CRLogin\core\DIC;

class Login implements Actions {

    /**
     * @var DIC 
     */
    private $_container;

    /**
     * @var string 
     */
    private $_username;

    /**
     * @var string 
     */
    private $_clienResponse;

    /**
     * @var array 
     */
    private $_l;

    /**
     * 
     * @param DIC $container
     */
    public function __construct(DIC $container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguageFile();
        $this->_username = $_POST['username'];
        $this->_clienResponse = $_POST['response'];
    }

    /**
     * Executes the 'login' action
     * Returns a control array for the client side script
     * 
     * @return array
     */
    public function executeAction() {
        $saltedPassword = $this->_returnSaltedPass();
        $challenge = $this->_returnChallenge();
        $serverResponse = $this->_returnResponse($saltedPassword, $challenge);
        $authentication = new Authentication($this->_clienResponse, $serverResponse);
        if ($authentication->isAuthenticated()) {
            return $this->_isLoggedIn($this->_username);
        } else {
            return $this->_isNotLoggedIn();
        }
    }

    /**
     * 
     * @return mixed
     */
    private function _returnSaltedPass() {
        $user = new User($this->_container);
        $user->setUserName($this->_username);
        return $user->getSaltedPass();
    }

    /**
     * 
     * @return mixed
     */
    private function _returnChallenge() {
        $challenge = new Challenge($this->_container);
        if ($challenge->fechChallenge()) {
            return $challenge->getChallenge();
        }
    }

    /**
     * 
     * @param string $saltedPassword
     * @param string $challenge
     * @return mixed
     */
    private function _returnResponse($saltedPassword, $challenge) {
        $serverResponse = new Response();
        $serverResponse->calculateResponse($saltedPassword, $challenge);
        return $serverResponse->getResponse();
    }

    /**
     * Performs the actions to set the user as logged in
     * 
     * @param string $username
     * @return array
     */
    private function _isLoggedIn($username) {
        if (isset($_SESSION['redirectURL'])) {
            $redirectUrl = $_SESSION['redirectURL'];
            unset($_SESSION['redirectURL']);
        } else {
            $redirectUrl = 'index.php';
        }
        session_regenerate_id(true);
        $_SESSION['logged'] = TRUE;
        $_SESSION['username'] = $username;
        return array(
            'redirect' => TRUE,
            'redirectURL' => $redirectUrl);
    }

    /**
     * Performs the actions to set the user as not logged in
     * 
     * @return array
     */
    private function _isNotLoggedIn() {
        $_SESSION['logged'] = FALSE;
        $_SESSION['username'] = FALSE;

        return array(
            'error' => TRUE,
            'errorMsg' => $this->_l['LOGIN_FAIL']
        );
    }

}

?>
