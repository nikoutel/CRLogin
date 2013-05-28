<?php

class User {

    private $_username;
    private $_saltedPass;
    private $_userSalt;
    private $_container;
    private $_db;

    public function __construct($container) {
        $this->_container = $container;
        $this->_db = $this->_container->getDb();
    }

    public function setUserName($username) {
        $this->_username = $username;
    }

    public function getUserSalt() {
        $field = 'usersalt';
        $dataset = 'user';
        $conditions = array('', 'username', '=', $this->_username);
        $this->_userSalt = $this->_db->read(array($field), $dataset, $conditions);

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
        $spassAraray = $this->_db->read(array($field), $dataset, $conditions);
        if (!empty($spassAraray)) {
            $this->_saltedPass = $spassAraray[0][$field];
            return $this->_saltedPass;
        }
        else
            return FALSE;
    }

}

?>
