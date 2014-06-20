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

class Login implements Actions {


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
     * @var Authentication 
     */
    private $_authentication;
    
    /**
     * @var User
     */
    private $_user;
    
    /**
     * @var Challenge
     */
    private $_challenge;
    
    /**
     * @var Response
     */
    private $_response;

    /**
     * @param array $languageFile
     * @param Authentication $authentication
     * @param User $user
     * @param Challemge $challenge
     * @param Response $response
     */
    public function __construct(
        $languageFile, 
        Authentication $authentication, 
        User $user, 
        Challenge $challenge, 
        Response $response
    ) {
        
        $this->_l = $languageFile;
        $this->_username = $_POST['username'];
        $this->_clienResponse = $_POST['response'];
        $this->_authentication = $authentication;
        $this->_user = $user;
        $this->_challenge = $challenge;
        $this->_response = $response;
        
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
        $this->_authentication->authenticate($this->_clienResponse, $serverResponse);
        
        if ($this->_authentication->isAuthenticated()) {
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

        $this->_user->setUserName($this->_username);
        return $this->_user->getSaltedPass();
    }

    /**
     * 
     * @return mixed
     */
    private function _returnChallenge() {

        if ($this->_challenge->fechChallenge()) {
            return $this->_challenge->getChallenge();
        }
    }

    /**
     * 
     * @param string $saltedPassword
     * @param string $challenge
     * @return mixed
     */
    private function _returnResponse($saltedPassword, $challenge) {

        $this->_response->calculateResponse($saltedPassword, $challenge);
        return $this->_response->getResponse();
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
            $redirectUrl = 'index0.php';
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
