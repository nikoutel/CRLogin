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

use CRLogin\core\lib\ConfigReader;
use CRLogin\core\lib\Configuration;
use CRLogin\core\lib\LanguageFile;
use CRLogin\core\lib\Session;
use CRLogin\core\lib\Utils;

class DIC {

    /**
     * @var DataAccessor 
     */
    private $_dataStore;

    /**
     * @var Utils 
     */
    private $_utils;

    /**
     * @var DataAccessor 
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
     * @return DataAccessor
     */
    public function getDataStore() {
        if (!isset($this->_dataStore)) {
            $config = $this->getConfiguration()->getConfigArray('general');
            if ($config['datastore'] == 'database') {
                $dbConfig = $this->getConfiguration()->getConfigArray('db');
                $utility = $this->getUtility();
                $database = 'CRLogin\DataAccess\\' . $dbConfig['databaseDriver'] . 'Database';
                $this->_dataStore = new $database($dbConfig, $utility);
            }
        }
        return $this->_dataStore;
    }

    /**
     * Initializes the session and returns the session object
     * 
     * @return Session
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
        } elseif ($className = $this->_isClass($className)) {

            $parameters = $this->_getClassParameters($className);
            if (!empty($parameters)) {

                foreach ($parameters as $param) {
                    $paramName = $param->name;
                    $paramClassName = ucfirst($paramName);
                    $arguments[] = $this->getObject($paramClassName);
                }
            } else {
                $arguments = array();
            }

            // @todo try catch
            $reflector = new \ReflectionClass($className);
            $obj = $reflector->newInstanceArgs($arguments);
        } else {
           throw new \Exception;
        }

        return $obj;
    }

    private function _isClass($className) {

        $subNamespaces = array(
            '\CRLogin\core\\',
            '\CRLogin\core\Actions\\'
        );

        foreach ($subNamespaces as $nspace) {

            $class = $nspace . $className;
            if (class_exists($class)) {
                return $class;
            }
        }
        return FALSE;
    }

}

?>
