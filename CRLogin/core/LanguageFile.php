<?php

namespace CRLogin\core;

class LanguageFile {

    private $_configReader;
    private $_languageArray;

    public function __construct() {
        $this->_configReader = new ConfigReader();
    }

    public function getLanguageArray($langCode) {
        $langFile = realpath($_SERVER["DOCUMENT_ROOT"]) . '/CRLogin/lang/lang.' . $langCode . '.php';
        if (file_exists($langFile)) {
            $this->_languageArray = $this->_configReader->readFile($langFile);
        } else {
            $langCode = 'en';
            $langFile = realpath($_SERVER["DOCUMENT_ROOT"]) . '/CRLogin/lang/lang.' . $langCode . '.php';
            $this->_languageArray = $this->_configReader->readFile($langFile);
        }
        return $this->_languageArray;
    }

}

?>
