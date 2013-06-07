<?php

namespace CRLogin\core\Actions;

class Actions_Register implements Actions_Actions {

    private $_container;
    private $_username;
    private $_saltedPassword;

    public function __construct($container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguage();
        $this->_username = $_POST['username'];
        $this->_saltedPassword = $_POST['cpass'];
    }

    public function executeAction() {
        $salt = $_SESSION['newsalt'];
        if (!$this->_validUsername($this->_username)){
            return array(
                    'error' => TRUE,
                    'errorMsg' => $this->_l['WRONG_USERNAME_FORM']
                );
        }
        $user = new User($this->_container);
        $user->setUserName($this->_username);
        if (!$user->userExists()) {
            $create = $user->createUser($this->_username, $this->_saltedPassword, $salt);
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
                //login ?
            }
        } else {
            return array(
                'error' => TRUE,
                'errorMsg' => $this->_l['USER_EXISTS']
            );
        }
    }
    
    private function _validUsername($username){
        if (preg_match('/^[a-zA-Z0-9-_]+$/D', $username)) {
            return TRUE;
        } else 
            return FALSE;
    }

}

?>
