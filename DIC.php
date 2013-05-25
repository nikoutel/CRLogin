<?php

class DIC {

    private $_db;
    private $_utils;
    private $_session;
    private $_configuration;

    public function __construct() {
        
    }

    public function getConfiguration($cat) {
        $this->_configuration = new Configuration();
        return $this->_configuration->getConfigArray($cat);
    }

    public function getDb() {
        if (!isset($this->_db)) {
            $dbConfig = $this->getConfiguration('db');
            $utility = $this->getUtility();
            $database = $dbConfig['databaseDriver'] . 'Database';
            $this->_db = new $database($dbConfig, $utility);
        }
        return $this->_db;
    }

    public function startSession() {
        if (!isset($this->_session)) {
            $utility = $this->getUtility();
            $db = $this->getDb();
            $this->_session = new Session($db, $utility);
        }
        return $this->_session;
    }

    public function getUtility() {
        if (!isset($this->_utils)) {
            $this->_utils = new Utils();
        }
        return $this->_utils;
    }

}

?>
