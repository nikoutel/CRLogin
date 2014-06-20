<?php

/**
 *
 * Authentication: Returns the authentication status according to the responses 
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

        if ($this->_clientResponse === $this->_serverResponse)
            $this->_isAuthenticated = TRUE;
        else
            $this->_isAuthenticated = FALSE;
    }

    /**
     * Returns the authentication status
     * 
     * @return boolean
     */
    public function isAuthenticated() {

        return $this->_isAuthenticated;
    }

}

?>
