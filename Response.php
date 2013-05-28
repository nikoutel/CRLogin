<?php

class Response {

    private $_response;

    public function __construct() {

    }

    public function setResponse($response) {
        
        $this->_response = $response;
    }

    public function calculateResponse($saltedPassword, $challenge) {
        
        $data = $saltedPassword . $challenge;
        $this->_response = hash('sha256', $data);
    }

    public function getResponse() {
        
        return $this->_response;
    }

}

?>
