<?php

/**
 *
 * ChangePassword: Executes and controls the 'changePassword' action
 * 
 * 
 * @package CRLogin
 * @subpackage core/Actions
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

namespace CRLogin\core\Actions;

use CRLogin\core\User;
use CRLogin\core\Crypt;

class ChangePassword implements Actions {


    /**
     * @var string 
     */
    private $_newPassword;

    /**
     * @var string 
     */
    private $_username;

    /**
     * @var array 
     */
    private $_l;
    
    /**
     * @var Login 
     */
    private $_login;

    /**
     * @var Crypt
     */
    private $_crypt;
    
    /**
     * @var User
     */
    private $_user;
    
    /**
     * @param array $languageFile
     * @param \CRLogin\core\Actions\Login $login
     * @param \CRLogin\core\Crypt $crypt
     * @param \CRLogin\core\User $user
     */
    public function __construct($languageFile, Login $login, Crypt $crypt, User $user) {

        $this->_l = $languageFile;
        $this->_username = $_POST['username'];
        $this->_newPassword = $_POST['newpassword'];
        $this->_login = $login;
        $this->_crypt = $crypt;
        $this->_user = $user;
        
    }

    /**
     * Executes the 'changePassword' action
     * Returns a control array for the client side script
     * 
     * @return array
     */
    public function executeAction() {

        $loginResponse = $this->_login->executeAction();
        if (isset($loginResponse['error']) && $loginResponse['error'] == TRUE) {
            return array(
                'error' => TRUE,
                'errorMsg' => $this->_l['LOGIN_CONFIRM_FAIL']
            );
        } else {
            return $this->_changePassword();
        }
    }

    /**
     * Controls the changing of the password
     * 
     * @return array
     */
    private function _changePassword() {

        $newSalt = $this->_crypt->getNewSalt();
        $spass = $this->_crypt->encrypt($this->_newPassword, $newSalt);

        $this->_user->setUserName($this->_username);
        $update = $this->_user->updateUserPass($spass, $newSalt);

        session_regenerate_id(true);
        $_SESSION['logged'] = TRUE;
        $_SESSION['username'] = $this->_username;
        if ($update !== FALSE) {
            return array(
                'msg' => TRUE,
                'msgtxt' => $this->_l['CHANGE_PASS_SUCCESS']
            );
        } else {
            return array(
                'error' => TRUE
            );
        }
    }

}

?>
