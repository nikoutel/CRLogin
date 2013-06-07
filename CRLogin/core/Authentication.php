<?php

namespace CRLogin\core;

class Authentication {

    private $_clientResponse;
    private $_serverResponse;
    private $_isAuthenticated = FALSE;

    public function __construct($clientResponse, $serverResponse) {

        $this->_clientResponse = $clientResponse;
        $this->_serverResponse = $serverResponse;
        $this->_compareResponse();
    }

    private function _compareResponse() {

        if ($this->_clientResponse === $this->_serverResponse)
            $this->_isAuthenticated = TRUE;
        else
            $this->_isAuthenticated = FALSE;
    }

    public function isAuthenticated() {

        return $this->_isAuthenticated;
    }

}

?>
