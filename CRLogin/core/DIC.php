<?php

namespace CRLogin\core;

use CRLogin\core\DataAccess\MySQLDatabase;
use CRLogin\core\DataAccess\SQLiteDatabase;

class DIC {

    private $_dataStore;
    private $_utils;
    private $_session;
    private $_configuration;
    private $_languageFile;

    public function __construct() {
        
    }

    public function getConfiguration($cat) {
        $this->_configuration = new Configuration();
        return $this->_configuration->getConfigArray($cat);
    }

    public function getLanguage() {
        $config = $this->getConfiguration('general');
        $langCode = $config['language'];
        $this->_languageFile = new LanguageFile;
        return $this->_languageFile->getLanguageArray($langCode);
    }

    public function getDataStore() {
        if (!isset($this->_dataStore)) {
            $config = $this->getConfiguration('general');
            if ($config['datastore'] == 'database') {
                $dbConfig = $this->getConfiguration('db');
                $utility = $this->getUtility();
                $database = 'CRLogin\core\DataAccess\\'.$dbConfig['databaseDriver'] . 'Database';
                $this->_dataStore = new $database($dbConfig, $utility);
            }
        }
        return $this->_dataStore;
    }

    public function startSession() {
        if (!isset($this->_session)) {
            $utility = $this->getUtility();
            $ds = $this->getDataStore();
            $config = $this->getConfiguration('general');
            $this->_session = new Session($ds, $config, $utility);
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
