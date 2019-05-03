<?php

/**
 *
 * Configuration: Handles the configuration data, files and arrays 
 *  
 * 
 * @package CRLogin
 * @subpackage core\lib
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013 Nikos Koutelidis 
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin 
 * 
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 */

namespace CRLogin\core\lib;

class Configuration {

    /**
     * name of the main configuration file
     * 
     * @var string 
     */
    private $_configFileScript = 'config/config.php';

    /**
     * @var string 
     */
    private $_configFile;

    /**
     * @var string 
     */
    private $_installConfigFile;

    /**
     * @var ConfigReader 
     */
    private $_configReader;

    /**
     * @var array 
     */
    private $_installConfigFileArray;

    /**
     * @var array 
     */
    private $_configFileArray;

    /**
     * @var array 
     */
    private $_configArray;

    /**
     * @var array 
     */
    private $_installConfigArray;

    /**
     * Initialization
     */
    public function __construct() {
        $this->_configFile = CRL_BASE_DIR .'/'. $this->_configFileScript;
        $this->_configReader = new ConfigReader();
        $this->getConfigFromFile($this->_configFile);
        $this->_installConfigFile = $this->_configFileArray['general']['dbConfigFile'];
        $this->getDbConfigFromFile($this->_installConfigFile);
        $this->setConfigArray();
        $this->setDbConfigArray();
    }

    /**
     * Returns the configuration array from the install configuration
     * 
     * @param string $configFile
     * @return array
     */
    public function getDbConfigFromFile($configFile) {

        if ($this->_installConfigFileArray = $this->_configReader->readFile($configFile)){
            return $this->_installConfigFileArray;
        } else {
            throw new \Exception('Configuration file not found');
        }
    }

    /**
     * Returns the configuration array from the main configuration
     * 
     * @param string $configFile
     * @return array
     */
    public function getConfigFromFile($configFile) {

        if ($this->_configFileArray = $this->_configReader->readFile($configFile)){
            return $this->_configFileArray;
        } else {
            throw new \Exception('Configuration file not found');
        }
    }

    /**
     * Sets the database configuration array
     * 
     * Itarates the arrays from the main and the install configuration, takes 
     * the appropriate fields and merges similar values
     */
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

    /**
     * Sets the main configuration array from
     * the main and the install configuration
     */
    public function setConfigArray() {
        $this->_configArray = array_merge($this->_configFileArray['general'], $this->_installConfigFileArray['general']);
    }

    /**
     * Returns the configuration array with category $cat
     * 
     * @param string $cat
     * @return array
     */
    public function getConfigArray($cat) {
        $cat = ucfirst(strtolower($cat));
        $configFunction = 'get' . $cat . 'ConfigArray';
        return $this->$configFunction();
    }

    /**
     * Returns the database configuration array 
     * 
     * @return array
     */
    public function getDbConfigArray() {
        return $this->_installConfigArray;
    }

    /**
     * Returns the main configuration array 
     * 
     * @return array
     */
    public function getGeneralConfigArray() {
        return $this->_configArray;
    }

}

?>
