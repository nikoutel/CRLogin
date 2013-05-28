<?php

class Response {

    private $_response;
    private $_container;
    private $_db;

    public function __construct($container) {
//        $this->_container = $container;
//        $this->_db = $this->_container->getDb();
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
