<?php

class Actions_Login implements Actions_Actions {

    private $_container;
    private $_username;
    private $_clienResponse;
    private $_l;

    public function __construct($container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguage();
        $this->_username = $_POST['username'];
        $this->_clienResponse = $_POST['response'];
//@todo validate?
    }

    public function executeAction() {
        $saltedPassword = $this->_returnSaltedPass();
        $challenge = $this->_returnChallenge();
        $serverResponse = $this->_returnResponse($saltedPassword, $challenge);
        $authentication = new Authentication($this->_clienResponse, $serverResponse);
        if ($authentication->isAuthenticated()) {
            return $this->_isLoggedIn($this->_username);
        } else {
            return $this->_isNotLoggedIn();
        }
    }

    private function _returnSaltedPass() {
        $user = new User($this->_container);
        $user->setUserName($this->_username);
        return $user->getSaltedPass();
    }

    private function _returnChallenge() {
        $challenge = new Challenge($this->_container);
        if ($challenge->fechChallenge()) {
            return $challenge->getChallenge();
        }
    }

    private function _returnResponse($saltedPassword, $challenge) {
        $serverResponse = new Response();
        $serverResponse->calculateResponse($saltedPassword, $challenge);
        return $serverResponse->getResponse();
    }

    private function _isLoggedIn($username) {
        if (isset($_SESSION['redirectURL'])) {
            $redirectUrl = $_SESSION['redirectURL'];
            unset($_SESSION['redirectURL']);
        } else {
            $redirectUrl = 'index.php';
        }
        session_regenerate_id(true);
        $_SESSION['logged'] = TRUE;
        $_SESSION['username'] = $username;
        return array(
            'redirect' => TRUE,
            'redirectURL' => $redirectUrl);
    }

    private function _isNotLoggedIn() {
        $_SESSION['logged'] = FALSE;
        $_SESSION['username'] = FALSE;

        return array(
            'error' => TRUE,
            'errorMsg' => $this->_l['LOGIN_FAIL']
        );
    }

}

?>
