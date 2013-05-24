<?php

class Configuration {

    private $_configFile = 'config.php';
    private $_dbConfigFile;
    private $_configReader;
    public $_dbConfigFileArray;
    private $_configFileArray;
    private $_configArray;
    public $_dbConfigArray;

    public function __construct() {
        $this->_configReader = new ConfigReader();
        $this->getConfigFromFile($this->_configFile);
        $this->_dbConfigFile = $this->_configFileArray['general']['dbConfigFile'];
        $this->getDbConfigFromFile($this->_dbConfigFile);
        $this->setConfigArray();
        $this->setDbConfigArray();
    }

    public function getDbConfigFromFile($configFile) {

        $this->_dbConfigFileArray = $this->_configReader->readFile($configFile);
        return $this->_dbConfigFileArray;
    }

    public function getConfigFromFile($configFile) {

        $this->_configFileArray = $this->_configReader->readFile($configFile);
        return $this->_configFileArray;
    }

    public function setDbConfigArray() {
        $this->_dbConfigArray = $this->_dbConfigFileArray;
        foreach ($this->_dbConfigArray as $dbConfigKey => $dbConfigValue) {
            foreach ($this->_configFileArray['db'] as $configFileKey => $configFileValue) {
                if ($dbConfigKey != $configFileKey) {
                    $this->_dbConfigArray[$configFileKey] = $configFileValue;
                } else {
                    if (is_array($configFileValue)) {
                        $this->_dbConfigArray[$dbConfigKey] = ($dbConfigValue + $configFileValue);
                    }
                }
            }
        }
    }

    public function setConfigArray() {
        $this->_configArray = $this->_configFileArray['general'];
    }

    public function getConfigArray($cat){
       $cat = ucfirst(strtolower($cat));
        $configFunction = 'get'.$cat.'ConfigArray';
        return $this->$configFunction();
    }

    public function getDbConfigArray() {
        return $this->_dbConfigArray;
    }

    public function getGeneralConfigArray() {
        return $this->_configArray;
    }

}

?>
