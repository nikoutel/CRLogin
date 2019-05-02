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
     * Returns Configuration object
     *
     * @return \CRLogin\core\lib\Configuration
     * @throws \Exception
     */
    public function getConfiguration() {
        try {
            $this->_configuration = new Configuration();
            return $this->_configuration;
        } catch (\Exception $ex) {
            session_start();
            $_SESSION['error'] = $ex->getMessage();
            $_SESSION['reinstall'] = TRUE;
            throw new \Exception ($ex->getMessage());
        }
    }

    /**
     * Returns the language array
     * 
     * @return array
     * @throws \Exception
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
     * @return \CRLogin\DataAccess\DataAccessor
     * @throws \Exception
     */
    public function getDataStore() {
        if (!isset($this->_dataStore)) {
            $config = $this->getConfiguration()->getConfigArray('general');
            if ($config['datastore'] == 'database') {
                $dbConfig = $this->getConfiguration()->getConfigArray('db');
                $utility = $this->getUtility();
                $database = CRL_APP_DIR . '\DataAccess\\' . $dbConfig['databaseDriver'] . 'Database';
                $this->_dataStore = new $database($dbConfig, $utility);
            }
        }
        return $this->_dataStore;
    }

    /**
     * Returns the session object
     * 
     * @return \CRLogin\core\lib\Session
     * @throws \Exception
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
     * @return \CRLogin\core\lib\Utils
     */
    public function getUtility() {
        if (!isset($this->_utils)) {
            $this->_utils = new Utils();
        }
        return $this->_utils;
    }

    /**
     * Returns an instance of $class, resolves all needed dependencies
     *
     * @param string $class
     * @return object
     * @throws \Exception
     * @throws \ReflectionException
     */
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

    /**
     * Returns an array with the parameters of $class
     *
     * @param string $class
     * @return array
     * @throws \ReflectionException
     */
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

    /**
     * Returns the fully qualified class name if the class exists,
     * and FALSE if class does not exist
     *
     * @param string $className
     * @return string|boolean
     */
    private function _isClass($className) {

        // whitelisting
        $subNamespaces = array(
            CRL_APP_DIR . '\core\\',
            CRL_APP_DIR . '\core\Actions\\'
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
