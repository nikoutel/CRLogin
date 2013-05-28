<?php

class Challenge {

    private $_challenge;
    private $_container;
    private $_dataStore;

    public function __construct($container) {

        session_start();
        $this->_container = $container;
        $this->_dataStore = $this->_container->getDataStore();
    }

    public function getChallenge() {

        return $this->_challenge;
    }

    public function createChallenge() {

        $challenge = sha1(uniqid(mt_rand()));

        $delete = $this->_deleteOldChallenge(); // first delete older (if any)

        $store = $this->_storeChallenge($challenge);
        if (($delete !== FALSE) && ($store !== FALSE)) {
            $this->_challenge = $challenge;
            return TRUE;
        } else {
            //@todo else
            return FALSE;
        }
    }

    private function _storeChallenge($challenge) {

        $dataset = 'challenge';
        $values = array(
            'challenge' => $challenge,
            'sessionid' => session_id(),
            'timestamp' => (time() + 15) //@todo  make dalay var //may make problem with firebug
        );
        return $this->_dataStore->create($values, $dataset);
    }

    private function _deleteOldChallenge() {

        $dataset = 'challenge';
        $conditions = array(
            array('', 'sessionid', '=', session_id()),
            array('OR', 'timestamp', '<', time())
        );
        return $this->_dataStore->delete($dataset, $conditions);
    }

    public function fechChallenge() {
        $field = 'challenge';
        $dataset = 'challenge';
        $conditions = array(
            array('', 'sessionid', '=', session_id()),
            array('AND', 'timestamp', '>', time()),
        );
        $challengeArray = $this->_dataStore->read(array($field), $dataset, $conditions);
        if (!empty($challengeArray)) {
            $this->_challenge = $challengeArray[0][$field];
            return TRUE;
        }
        else
            return FALSE;
    }

}

?>
