<?php

/**
 *
 * Register: Executes and controls the 'register' action
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

class Register implements Actions {


    /**
     * @var string 
     */
    private $_username;

    /**
     * @var string 
     */
    private $_saltedPassword;
    
    /**
     * @var User
     */
    private $_user;

    /**
     * 
     * @param array $languageFile
     * @param User $user
     */
    public function __construct($languageFile, User $user) {

        $this->_l = $languageFile;
        $this->_username = $_POST['username'];
        $this->_saltedPassword = $_POST['cpass'];
        $this->_user = $user;
    }

    /**
     * Executes the 'register' action
     * Returns a control array for the client side script
     * 
     * @return array
     */
    public function executeAction() {
        $salt = $_SESSION['newsalt'];
        if (!$this->_validUsername($this->_username)) {
            return array(
                'error' => TRUE,
                'errorMsg' => $this->_l['WRONG_USERNAME_FORM']
            );
        }

        $this->_user->setUserName($this->_username);
        if (!$this->_user->userExists()) {
            $create = $this->_user->createUser($this->_username, $this->_saltedPassword, $salt);
            if ($create === FALSE) {
                return array(
                    'error' => TRUE,
                    'errorMsg' => ''
                );
            } else {
                return array(
                    'msg' => TRUE,
                    'msgtxt' => $this->_l['REGISTER_SUCCESS']
                );
            }
        } else {
            return array(
                'error' => TRUE,
                'errorMsg' => $this->_l['USER_EXISTS']
            );
        }
    }

    /**
     * Validates the username
     * 
     * @param string $username
     * @return boolean
     */
    private function _validUsername($username) {
        if (preg_match('/^[a-zA-Z0-9-_]+$/D', $username)) {
            return TRUE;
        }
        else
            return FALSE;
    }

}

?>
