<?php

/**
 *
 * LanguageFile: Returns the language array from the language file
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

class LanguageFile {

    /**
     * @var obj 
     */
    private $_configReader;

    /**
     * @var array 
     */
    private $_languageArray;

    /**
     * @param \CRLogin\core\ConfigReader $configReader
     */
    public function __construct(ConfigReader $configReader) {
        $this->_configReader = $configReader;
    }

    /**
     * Returns the language array
     * 
     * @param string $langCode
     * @return array
     */
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
