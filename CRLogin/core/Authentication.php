<?php

/**
 *
 * Authentication: Returns the authentication status according to the responses 
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

class Authentication {

    /**
     * @var string 
     */
    private $_clientResponse;

    /**
     * @var string 
     */
    private $_serverResponse;

    /**
     * @var boolean 
     */
    private $_isAuthenticated = FALSE;

    /**
     * Sets the client and server responses, and initializes the comparison 
     * 
     * @param string $clientResponse
     * @param string $serverResponse
     */
    public function authenticate($clientResponse, $serverResponse) {

        $this->_clientResponse = $clientResponse;
        $this->_serverResponse = $serverResponse;
        $this->_compareResponse();
    }

    /**
     * Compares the client response with the server response
     */
    private function _compareResponse() {

        $actual = $this->_clientResponse;
        $expected = $this->_serverResponse;

        if ($this->_compareStrings($expected, $actual)) {
            $this->_isAuthenticated = TRUE;
        } else {
            $this->_isAuthenticated = FALSE;
        }
    }

    /**
     * Returns the authentication status
     * 
     * @return boolean
     */
    public function isAuthenticated() {

        return $this->_isAuthenticated;
    }

    /**
     * Compare two strings to avoid timing attacks
     *
     * C function memcmp() internally used by PHP, exits as soon as a difference
     * is found in the two buffers. That makes possible of leaking
     * timing information useful to an attacker attempting to iteratively guess
     * the unknown string (e.g. password).
     *
     * Zend Framework (http://framework.zend.com/)
     *
     * @link http://github.com/zendframework/zf2 for the canonical source repository
     * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
     * @license http://framework.zend.com/license/new-bsd New BSD License
     * 
     * @param string $expected
     * @param string $actual
     * @return bool
     */
    private function _compareStrings($expected, $actual) {
        $expected = (string) $expected;
        $actual = (string) $actual;
        $lenExpected = strlen($expected);
        $lenActual = strlen($actual);
        $len = min($lenExpected, $lenActual);

        $result = 0;
        for ($i = 0; $i < $len; $i++) {
            $result |= ord($expected[$i]) ^ ord($actual[$i]);
        }
        $result |= $lenExpected ^ $lenActual;

        return ($result === 0);
    }

}

?>
