<?php

namespace CRLogin\core\Actions;

class Actions_GetChallenge implements Actions_Actions {

    private $_container;
    private $_username;
    private $_l;

    public function __construct($container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguageFile();
        $this->_username = $_POST['username'];
        //@todo validate?
    }

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

    private function _returnChallenge() {
        $challenge = new Challenge($this->_container);
        if ($challenge->createChallenge()) {
            return $challenge->getChallenge();
        } else {
            return FALSE; //array('error' => TRUE);
        }
    }

}

?>
