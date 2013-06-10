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

namespace CRLogin\core\Actions;

use CRLogin\core\User;
use CRLogin\core\Crypt;
use CRLogin\core\Challenge;
use CRLogin\core\DIC;

class GetChallenge implements Actions {

    /**
     * @var DIC 
     */
    private $_container;

    /**
     * @var string 
     */
    private $_username;

    /**
     * @var array 
     */
    private $_l;

    /**
     * @param DIC $container
     */
    public function __construct(DIC $container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguageFile();
        $this->_username = $_POST['username'];
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
        $user = new User($this->_container);
        $user->setUserName($this->_username);
        $salt = $user->getUserSalt();
        if ($salt === FALSE) {
            $crypt = new Crypt($this->_container);
            $salt = $crypt->getNewSalt();
        }
        return $salt;
    }

    /**
     * 
     * @return mixed
     */
    private function _returnChallenge() {
        $challenge = new Challenge($this->_container);
        if ($challenge->createChallenge()) {
            return $challenge->getChallenge();
        } else {
            return FALSE;
        }
    }

}

?>
