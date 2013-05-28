<?php

class DIC {

    private $_dataStore;
    private $_utils;
    private $_session;
    private $_configuration;

    public function __construct() {
        
    }

    public function getConfiguration($cat) {
        $this->_configuration = new Configuration();
        return $this->_configuration->getConfigArray($cat);
    }

    public function getDataStore() {
        if (!isset($this->_dataStore)) {
            $config= $this->getConfiguration('general');
            if ($config['datastore'] == 'database') {
                $dbConfig = $this->getConfiguration('db');
                $utility = $this->getUtility();
                $database = $dbConfig['databaseDriver'] . 'Database';
                $this->_dataStore = new $database($dbConfig, $utility);
            }
        }
        return $this->_dataStore;
    }

    public function startSession() {
        if (!isset($this->_session)) {
            $utility = $this->getUtility();
            $ds = $this->getDataStore();
            $this->_session = new Session($ds, $utility);
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
