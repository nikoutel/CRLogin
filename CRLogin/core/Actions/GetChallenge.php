<?php

/**
 *
 * GetChallenge: Executes and controls the 'getChallenge' action
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

namespace CRLogin\core;

use CRLogin\core\User;
use CRLogin\core\Crypt;
use CRLogin\core\Challenge;

class GetChallenge implements Actions {


    /**
     * @var string 
     */
    private $_username;

    /**
     * @var array 
     */
    private $_l;
    
    /**
     * @var User
     */
    private $_user;
    
    /**
     * @var Crypt
     */
    private $_crypt;
    
    /**
     * @var Challenge
     */
    private $_challenge;

    /**
     * 
     * @param array $languageFile
     * @param User $user
     * @param Crypt $crypt
     * @param Challenge $challenge
     */
    public function __construct($languageFile, User $user, Crypt $crypt, Challenge $challenge) {

        $this->_l = $languageFile;
        $this->_username = $_POST['username'];
        $this->_user = $user;
        $this->_crypt = $crypt;
        $this->_challenge = $challenge;
    }

    /**
     * Executes the 'getChallenge' action
     * Returns a control array for the client side script
     * 
     * @return array
     */
    public function executeAction() {
        $username = trim($this->_username);
        if (empty($username)) {
            $returnArray = array(
                'error' => TRUE,
                'errorMsg' => $this->_l['EMPTY_USERNAME']
            );
            return $returnArray;
        }

        if ($this->_returnChallenge() === FALSE || $this->_returnSalt() === FALSE) {
            $returnArray = array(
                'error' => TRUE
            );
            return $returnArray;
        }
        $returnArray = array(
            'error' => FALSE,
            'challenge' => $this->_returnChallenge(),
            'usersalt' => $this->_returnSalt()
        );
        return $returnArray;
    }

    /**
     * 
     * @return mixed
     */
    private function _returnSalt() {
        
        $this->_user->setUserName($this->_username);
        $salt = $this->_user->getUserSalt();
        if ($salt === FALSE) {
            $salt = $this->_crypt->getNewSalt();
        }
        return $salt;
    }

    /**
     * 
     * @return mixed
     */
    private function _returnChallenge() {

        if ($this->_challenge->createChallenge()) {
            return $this->_challenge->getChallenge();
        } else {
            return FALSE;
        }
    }

}

?>
