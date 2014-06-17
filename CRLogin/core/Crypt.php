<?php

/**
 *
 * Crypt: Performs cryptographical actions
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

class Crypt {
    
    /**
     * @var string 
     */
    private $_salt;
    
    /**
     * @var string 
     */
    private $_random;
    
    /**
     * @var array 
     */
    private $_configArray;
    
    /**
     * @param array $configArray
     */
    public function __construct($configArray) {
        
        $this->_configArray = $configArray['general'];
    }

    /**
     * Hashes the $string using $salt
     * The hash algorithmous depends on the form of $salt
     * 
     * @param string $string
     * @param string $salt
     * @return mixed
     */
    public function encrypt($string, $salt) {

        $hash = crypt($string, $salt);

        if (strlen($hash) > 13)
            return $hash;
        else
            return false;
    }

    /**
     * Generates salt for bCrypt hashing
     */
    private function _generateSalt() {
        $configuration = $this->_configArray['general'];
        $costParameter = $configuration['cryptCostParameter'];
        if (version_compare(PHP_VERSION, '5.3.7', '>')) {
            $prefix = '$2y$';
        } else {
            $prefix = '$2a$';
        }
        $innerSalt = $this->getRandom($encode = 'salt');

        if ($innerSalt !== FALSE) {
            $this->_salt = $prefix . $costParameter . '$' . $innerSalt . '$';
        }
        else
            $this->_salt = FALSE;
    }

    /**
     * Returns a new salt
     * 
     * @return string
     */
    public function getNewSalt() {
        if (empty($this->_salt)) {
            $this->_generateSalt();
        }
        return $this->_salt;
    }

    /**
     * Returns a random string
     * 
     * @param mixed $encode
     * @return string
     */
    public function getRandom($encode = FALSE) {

        if ($encode == 'challenge') {
            $size = 32;
        } else {
            $size = 16;
        }

        $this->_random = '';
        if (function_exists('mcrypt_create_iv')) {
            if (defined('MCRYPT_DEV_URANDOM')) {
                $source = MCRYPT_DEV_URANDOM;
            } else {
                $source = MCRYPT_RAND; //
            }

            $this->_random = mcrypt_create_iv($size, $source);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {

            $this->_random = openssl_random_pseudo_bytes($size);
        } elseif (is_readable('/dev/urandom') && ($fp = @fopen('/dev/urandom', 'rb')) !== FALSE) {

            $this->_random .= @fread($fp, $size);
            @fclose($fp);
        } else {

            $this->_random = sha1(uniqid(mt_rand()));
        }
        if (!$encode)
            return $this->_random;
        else
            return $this->_encode($this->_random, $encode);
    }

    /**
     * Encodes a random string according to $encode
     * 
     * @param string $random
     * @param mixed $encode
     * @return mixed
     */
    private function _encode($random, $encode) {

        if ($encode == 'salt') {
            return substr(strtr(base64_encode($random), '+', '.'), 0, 22);
        } elseif ($encode == 'challenge') {
            return substr(base64_encode($random), 0, 40);
        } else {
            return FALSE;
        }
    }

}

?>
