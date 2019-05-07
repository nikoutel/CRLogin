<?php

/**
 *
 * Crypt: Performs cryptographic actions
 * 
 * 
 * @package CRLogin
 * @subpackage core
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013-2019 Nikos Koutelidis
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

use CRLogin\core\lib\Configuration;

class Crypt {

    /**
     * @var string 
     */
    private $_salt;

    /**
     * @var string 
     */
    private $_dummySalt;

    /**
     * @var string
     */
    private $_dummyUserName;

    /**
     * @var string 
     */
    private $_random;

    /**
     * @var Configuration 
     */
    private $_configuration;

    /**
     * @var array 
     */
    private $_configArray;

    /**
     * @param \CRLogin\core\lib\Configuration $configuration
     */
    public function __construct(Configuration $configuration) {

        $this->_configuration = $configuration;
        $this->_configArray = $this->_configuration->getConfigArray('general');
    }

    /**
     * Hashes the $string using $salt
     * The hash algorithm depends on the form of $salt
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
     * Generates salt for bCrypt hashing
     */
    private function _generateSalt() {

        $costParameter = $this->_configArray['cryptCostParameter'];
        if (version_compare(PHP_VERSION, '5.3.7', '>')) {
            $prefix = '$2y$';
        } else {
            $prefix = '$2a$';
        }
        $innerSalt = $this->getRandom($encode = 'salt');

        if ($innerSalt !== FALSE) {
            $this->_salt = $prefix . $costParameter . '$' . $innerSalt . '$';
        } else {
            $this->_salt = FALSE;
        }
    }

    /**
     * Returns a dummy salt for a non existing user
     * 
     * @param string $userName
     * @return string
     */
    public function getDummySalt($userName) {

        $this->_dummyUserName = $userName;

        if (empty($this->_dummySalt)) {
            $this->_generateDummySalt();
        }
        return $this->_dummySalt;
    }

    /**
     * Generates a dummy salt
     */
    private function _generateDummySalt() {
        $installUniqueId = $this->_configArray['installUniqueId'];
        $dummyUserName = $this->_dummyUserName;
        $uid = $installUniqueId . $dummyUserName;
        $hashedUid = hash('sha256', $uid);
        $innerSalt = $this->_encode($hashedUid, 'salt');
        $costParameter = $this->_configArray['cryptCostParameter'];
        if (version_compare(PHP_VERSION, '5.3.7', '>')) {
            $prefix = '$2y$';
        } else {
            $prefix = '$2a$';
        }
        if ($innerSalt !== FALSE) {
            $this->_dummySalt = $prefix . $costParameter . '$' . $innerSalt . '$';
        } else {
            $this->_dummySalt = FALSE;
        }
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
        $next = TRUE;
        if (function_exists("random_bytes")) {
            try {
                $this->_random = random_bytes($size);
                $next = FALSE;
            } catch (\Exception $e) {
                // DO NOTHING
            }
        }
        if (function_exists('mcrypt_create_iv') && defined('MCRYPT_DEV_URANDOM') && ($next)) {

            $source = MCRYPT_DEV_URANDOM;
            $this->_random = mcrypt_create_iv($size, $source);
            if ($this->_random) {
                $next = FALSE;
            }

        }
        if (function_exists('openssl_random_pseudo_bytes') && ($next)) {

            $this->_random = openssl_random_pseudo_bytes($size, $cstrong);
            if ($this->_random && $cstrong) {
                $next = FALSE;
            }

        }
        if (is_readable('/dev/urandom') && ($fp = @fopen('/dev/urandom', 'rb')) !== FALSE && ($next)) {

            $this->_random = @fread($fp, $size);
            @fclose($fp);
            if ($this->_random) {
                $next = FALSE;
            }
        }
        if ($next) {

            mt_srand(microtime(true) * 100000 + memory_get_usage(true));
            $this->_random = substr(hash('sha256', uniqid(mt_rand(), true)), 0, $size);
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
