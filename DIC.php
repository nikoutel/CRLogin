<?php

class DIC {

    private $_db;
    private $_utils;
    private $_configReader;
    private $_dbConfigArray;
    private $_configArray;
    private $_dbConfigFile;
    private $_configFile = 'config.php';

    public function __construct() {
        $this->_configReader = new ConfigReader();
        $this->_utils = new Utils();

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
            $this->_db = new Database(
                    $this->_utils,
                    $this->_dbConfigArray['dsn'], 
                    $this->_dbConfigArray['username'], 
                    $this->_dbConfigArray['password'], 
                   array_merge($this->_configArray['dbOptions'],  $this->_dbConfigArray['driverOptions'])
            );
        }

        return $this->_db;
    }

}

?>
