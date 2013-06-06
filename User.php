<?php

class User {

    private $_username;
    private $_saltedPass;
    private $_userSalt;
    private $_container;
    private $_dataStore;
    private $_userId;

    public function __construct($container) {
        $this->_container = $container;
        $this->_dataStore = $this->_container->getDataStore();
    }

    public function setUserName($username) {
        $this->_username = $username;
    }

    public function getUserName() {
        return $this->_username;
    }

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

    public function userExists() {
        if ($this->getId() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
