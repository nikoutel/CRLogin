<?php

namespace CRLogin\core;

class Configuration {

    private $_configFileScript = 'config/config.php';
    private $_configFile;
    private $_installConfigFile;
    private $_configReader;
    private $_installConfigFileArray;
    private $_configFileArray;
    private $_configArray;
    private $_installConfigArray;

    public function __construct() {
        $this->_configFile = realpath($_SERVER["DOCUMENT_ROOT"] . '/CRLogin/' . $this->_configFileScript);
        $this->_configReader = new ConfigReader();
        $this->getConfigFromFile($this->_configFile);
        $this->_installConfigFile = $this->_configFileArray['general']['dbConfigFile'];
        $this->getDbConfigFromFile($this->_installConfigFile);
        $this->setConfigArray();
        $this->setDbConfigArray();
    }

    public function getDbConfigFromFile($configFile) {

        $this->_installConfigFileArray = $this->_configReader->readFile($configFile);
        return $this->_installConfigFileArray;
    }

    public function getConfigFromFile($configFile) {

        $this->_configFileArray = $this->_configReader->readFile($configFile);
        return $this->_configFileArray;
    }

    public function setDbConfigArray() {
        $this->_installConfigArray = $this->_installConfigFileArray['db'];
        foreach ($this->_installConfigArray as $dbConfigKey => $dbConfigValue) {
            foreach ($this->_configFileArray['db'] as $configFileKey => $configFileValue) {
                if ($dbConfigKey != $configFileKey) {
                    $this->_installConfigArray[$configFileKey] = $configFileValue;
                } else {
                    if (is_array($configFileValue)) {
                        $this->_installConfigArray[$dbConfigKey] = ($dbConfigValue + $configFileValue);
                    }
                }
            }
        }
    }

    public function setConfigArray() {
        $this->_configArray = array_merge($this->_configFileArray['general'], $this->_installConfigFileArray['general']);
    }

    public function getConfigArray($cat) {
        $cat = ucfirst(strtolower($cat));
        $configFunction = 'get' . $cat . 'ConfigArray';
        return $this->$configFunction();
    }

    public function getDbConfigArray() {
        return $this->_installConfigArray;
    }

    public function getGeneralConfigArray() {
        return $this->_configArray;
    }

}

?>
