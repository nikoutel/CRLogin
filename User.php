<?php

class User {

    private $_username;
    private $_saltedPass;
    private $_userSalt;
    private $_container;
    private $_dataStore;

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

}

?>
