<?php

/**
 *
 * DIC:  Dependency Injection Container
 * 
 * 
 * @package CRLogin
 * @subpackage core
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

namespace CRLogin\core;

class DIC {

    /**
     * @var resource 
     */
    private $_dataStore;

    /**
     * @var Utils 
     */
    private $_utils;

    /**
     * @var resource 
     */
    private $_session;

    /**
     * @var array 
     */
    private $_configuration;

    /**
     * @var obj 
     */
    private $_languageFile;

    public function __construct() {
        
    }

    /**
     * Returns configuratin array with catagory $cat
     * 
     * @param string $cat
     * @return array
     */
    public function getConfiguration() {
        $this->_configuration = new Configuration();
        return $this->_configuration;
    }

    /**
     * Returns the language array
     * 
     * @return array
     */
    public function getLanguageFile() {
        $config = $this->getConfiguration()->getConfigArray('general');
        $langCode = $config['language'];
        $this->_languageFile = new LanguageFile(new ConfigReader);
        return $this->_languageFile->getLanguageArray($langCode);
    }

    /**
     * Returns the data store
     * 
     * @return resource
     */
    public function getDataStore() {
        if (!isset($this->_dataStore)) {
            $config = $this->getConfiguration()->getConfigArray('general');
            if ($config['datastore'] == 'database') {
                $dbConfig = $this->getConfiguration()->getConfigArray('db');
                $utility = $this->getUtility();
                $database = 'CRLogin\core\DataAccess\\' . $dbConfig['databaseDriver'] . 'Database';
                $this->_dataStore = new $database($dbConfig, $utility);
            }
        }
        return $this->_dataStore;
    }

    /**
     * Initializes the session and returns the session resource
     * 
     * @return resource
     */
    public function getSession() {
        if (!isset($this->_session)) {
            $utility = $this->getUtility();
            $ds = $this->getDataStore();
            $config = $this->getConfiguration()->getConfigArray('general');
            $this->_session = new Session($ds, $config, $utility);
        }
        return $this->_session;
    }

    /**
     * Returns the Utility object
     * 
     * @return Utils
     */
    public function getUtility() {
        if (!isset($this->_utils)) {
            $this->_utils = new Utils();
        }
        return $this->_utils;
    }

    private function _getClassParameters($class) {

        // @todo try catch
        $reflectionClass = new \ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        if ($constructor !== NULL) {
            $constructor_parameters = $constructor->getParameters();
        } else {
            $constructor_parameters = array();
        }

        return $constructor_parameters;
    }

    public function getObject($class) {


        $className = ucfirst($class);
        $fName = 'get' . $className;

        if (method_exists($this, $fName)) {
            $obj = call_user_func(array($this, $fName));
        } elseif (class_exists($className)) {
            $parameters = $this->_getClassParameters($className);
            if (!empty($parameters)) {

                foreach ($parameters as $param) {
                    $paramName = $param->name;
                    $className = ucfirst($paramName);
                    $arguments[] = $this->getObject($className);
                }
            } else {
                $arguments = array();
            }
            
            // @todo try catch
            $reflector = new \ReflectionClass($class);
            $obj = $reflector->newInstanceArgs($arguments);
        }// @todo else throw exception

        return $obj;
    }

}

?>
