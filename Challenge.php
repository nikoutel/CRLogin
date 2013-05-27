<?php

class Challenge {

    private $_challenge;
    private $_container;
    private $_db;

    public function __construct($container) {
        session_start();
        $this->_container = $container;
        $this->_db = $this->_container->getDb();

        $this->_createChallenge();
        $this->_deleteOldChallenge();// first delete older (if any)
        $this->_storeChallenge();
    }

    public function getChallenge() {

        return $this->_challenge;
    }

    private function _createChallenge() {

        $this->_challenge = sha1(uniqid(mt_rand()));
    }

    private function _storeChallenge() {
        
        $dataset = 'challenge';
        $values = array(
            'challenge' => $this->_challenge,
            'sessionid' => session_id(),
            'timestamp' => (time() + 5) // make 5 var
        );
        return $this->_db->create($values, $dataset);
    }

    private function _deleteOldChallenge() {
        
        $dataset = 'challenge';
        $conditions = array(
            array('', 'sessionid', '=', session_id()),
            array('OR', 'timestamp', '<', time())
        );
        return $this->_db->delete($dataset, $conditions);
    }

}

?>
