<?php

namespace CRLogin\core;

class LanguageFile {

    private $_configReader;
    private $_languageArray;

    public function __construct() {
        $this->_configReader = new ConfigReader();
    }

    public function getLanguageArray($langCode) {
        $langFile = 'CRLogin/lang/lang.' . $langCode . '.php';
        if (file_exists($langFile)) {
            $this->_languageArray = $this->_configReader->readFile($langFile);
                } else {
            $this->_languageArray = $this->_configReader->readFile('lang/lang.eng.php');
        }
        return $this->_languageArray;
    }

}

?>
