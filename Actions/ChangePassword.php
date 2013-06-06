<?php

class Actions_ChangePassword {

    private $_container;
    private $_newPassword;

    public function __construct($container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguage();
        $this->_username = $_POST['username'];
        $this->_newPassword = $_POST['newpassword'];
    }

    public function executeAction() {
        $login = new actions_Login($this->_container);
        $loginResponse = $login->executeAction();
        if (isset($loginResponse['error']) && $loginResponse['error'] == TRUE) {
            return array(
                'error' => TRUE,
                'errorMsg' => $this->_l['LOGIN_CONFIRM_FAIL']
            );
        } else {
            return $this->_changePassword();
        }
    }

    private function _changePassword() {
        $crypt = new Crypt($this->_container);
        $newSalt = $crypt->getNewSalt();
        $spass = $crypt->encrypt($this->_newPassword, $newSalt);
        
        $user = new User($this->_container);
        $user->setUserName($this->_username);
        $update = $user->updateUserPass($spass, $newSalt);
        
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
