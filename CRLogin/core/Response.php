<?php

/**
 *
 * Response: Handles the response
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

class Response {

    /**
     * @var string 
     */
    private $_response;

    /**
     * Sets the response
     * 
     * @param string $response
     */
    public function setResponse($response) {

        $this->_response = $response;
    }

    /**
     * Calculates the response
     * 
     * @param string $saltedPassword
     * @param string $challenge
     */
    public function calculateResponse($saltedPassword, $challenge) {

        $this->_response = hash_hmac('sha256', $challenge, $saltedPassword);

        }

    /**
     * Returns the response
     * 
     * @return string
     */
    public function getResponse() {

        return $this->_response;
    }

}

?>
