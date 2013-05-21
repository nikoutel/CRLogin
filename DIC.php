<?php

class DIC {

    private $_db;
    public $utils;
    private $_session;
    private $_configReader;
    private $_dbConfigArray;
    private $_configArray;
    private $_dbConfigFile;
    private $_configFile = 'config.php';

    public function __construct() {
        $this->_configReader = new ConfigReader();
        $this->utils = new Utils();

        $this->getConfig($this->_configFile);
        $this->_dbConfigFile = $this->_configArray['dbConfigFile'];
        $this->getDbConfig($this->_dbConfigFile);
    }

    public function getDbConfig($configFile) {
        $this->_dbConfigArray = $this->_configReader->readFile($configFile);
        return $this->_dbConfigArray;
    }

    public function getConfig($configFile) {
        $this->_configArray = $this->_configReader->readFile($configFile);
        return $this->_configArray;
    }

    public function getDb() {
        if (!isset($this->_db)) {
            $database = $this->_dbConfigArray['databaseDriver'].'Database';
            $this->_db = new  $database(
                    $this->utils,
                    $this->_dbConfigArray['dsn'], 
                    $this->_dbConfigArray['username'], 
                    $this->_dbConfigArray['password'], 
                   array_merge($this->_configArray['dbOptions'],  $this->_dbConfigArray['driverOptions'])
            );
        }

        return $this->_db;
    }
    
    public function startSession(){
        $this->_session = new Session($this->_db, $this->utils);
    }

}

?>
