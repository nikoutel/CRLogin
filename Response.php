<?php

class Response {

    private $_clientResponse;
    private $_serverResponse;

    public function setClientResponse($response) {
        $this->_clientResponse = $response;
    }

    public function setServerResponse($response) {
        $this->_serverResponse = $response;
    }

    public function compareResponse() {
        
    }

}

?>
