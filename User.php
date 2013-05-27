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
        $dataset = 'username';
        $conditions = array('', $dataset, '=', $this->username);
        $this->userSalt = $this->_db->read(array($field), 'user', $conditions);

        Debugr::edbgLog($this->userSalt, '$this->userSalt');
        if (!empty($this->userSalt)) {
            return $this->userSalt[0][$field];
        }
        else
            return FALSE;
    }

    public function getSaltedPass() {

        return $this->saltedPass;
    }

}

?>
