<?php

class User {

    public $username;
    public $saltedPass;
    public $userSalt;
    private $_container;
    private $_db;

    public function __construct($container) {
        $this->_container = $container;
        $this->_db = $this->_container->getDb();
    }

    public function setUserName($username) {
        $this->username = $username;
    }

    public function getUserSalt() {
        $field = 'usersalt';
        $dataset = 'user';
        $conditions = array('', 'username', '=', $this->username);
        $this->userSalt = $this->_db->read(array($field), $dataset, $conditions);

        if (!empty($this->userSalt)) {
            return $this->userSalt[0][$field];
        }
        else
            return FALSE;
    }

    public function getSaltedPass() {
        $field = 'spass';
        $dataset = 'user';
        $conditions = array('', 'username', '=', $this->username);
        $spassAraray = $this->_db->read(array($field), $dataset, $conditions);
        if (!empty($spassAraray)) {
            $this->saltedPass = $spassAraray[0][$field];
            return $this->saltedPass;
        }
        else
            return FALSE;
        
    }

}

?>
