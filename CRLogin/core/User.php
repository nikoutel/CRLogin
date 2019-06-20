<?php

/**
 *
 * User: Handles the users
 * 
 * 
 * @package CRLogin
 * @subpackage core
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

namespace CRLogin\core;

use CRLogin\DataAccess\DataAccessor;

class User {

    /**
     * @var string 
     */
    private $_username;

    /**
     * @var string 
     */
    private $_saltedPass;

    /**
     * @var string 
     */
    private $_userSalt;

    /**
     * @var DataAccessor 
     */
    private $_dataStore;

    /**
     * @var string 
     */
    private $_userId;

    /**
     * @param \CRLogin\DataAccess\DataAccessor $dataStore
     */
    public function __construct(DataAccessor $dataStore) {

        $this->_dataStore = $dataStore;
    }

    /**
     * Sets the username
     * 
     * @param string $username
     */
    public function setUserName($username) {
        $this->_username = $username;
    }

    /**
     * Returns the username
     * 
     * @return string
     */
    public function getUserName() {
        return $this->_username;
    }

    /**
     * Returns the user salt or false on failure
     * 
     * @return mixed
     */
    public function getUserSalt() {
        $field = 'usersalt';
        $dataset = 'user';
        $conditions = array('', 'username', '=', $this->_username);
        $this->_userSalt = $this->_dataStore->read(array($field), $dataset, $conditions);

        if (!empty($this->_userSalt)) {
            return $this->_userSalt[0][$field];
        }
        else
            return FALSE;
    }

    /**
     * Returns the salted password or false on failure
     * 
     * @return mixed
     */
    public function getSaltedPass() {
        $field = 'spass';
        $dataset = 'user';
        $conditions = array('', 'username', '=', $this->_username);
        $spassArray = $this->_dataStore->read(array($field), $dataset, $conditions);
        if (!empty($spassArray)) {
            $this->_saltedPass = $spassArray[0][$field];
            return $this->_saltedPass;
        }
        else
            return FALSE;
    }

    /**
     * Updates the users salted password or false on failure
     *  
     * @param string $newPassword
     * @param string $newSalt
     * @return mixed
     */
    public function updateUserPass($newPassword, $newSalt) {
        $values = array(
            'spass' => $newPassword,
            'usersalt' => $newSalt
        );
        $dataset = 'user';
        $conditions = array('', 'username', '=', $this->_username);
        $update = $this->_dataStore->update($values, $dataset, $conditions);
        return $update;
    }

    /**
     * Creates new user
     * 
     * @param string $username
     * @param string $saltedPassword
     * @param string $salt
     * @return mixed
     */
    public function createUser($username, $saltedPassword, $salt) {
        $values = array(
            'username' => $username,
            'spass' => $saltedPassword,
            'usersalt' => $salt
        );
        $dataset = 'user';
        $create = $this->_dataStore->create($values, $dataset);
        return $create;
    }

    /**
     * Returns the users Id or false on failure 
     * 
     * @return mixed
     */
    public function getId() {
        $field = 'userid';
        $dataset = 'user';
        $conditions = array('', 'username', '=', $this->_username);
        $id = $this->_dataStore->read(array($field), $dataset, $conditions);
        if (!empty($id)) {
            $this->_userId = $id[0][$field];
            return $this->_userId;
        }
        else
            return FALSE;
    }

    /**
     * Check for user existence
     * 
     * @return boolean
     */
    public function userExists() {
        if ($this->getId() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
