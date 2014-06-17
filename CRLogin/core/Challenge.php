<?php

/**
 *
 * Challenge: Handles the challenge
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

class Challenge {

    /**
     * @var string 
     */
    private $_challenge;

    /**
     * @var resource 
     */
    private $_dataStore;

    /**
     * @var array 
     */
    private $_configArray;
    
    /**
     * @var Crypt 
     */
    private $_crypt;
    
    /**
     * 
     * @param type $dataStore
     * @param type $configArray
     * @param \CRLogin\core\Crypt $crypt
     */
    public function __construct($dataStore, $configArray, Crypt $crypt) {

        $this->_dataStore = $dataStore;
        $this->_configArray = $configArray['general'];
        $this->_crypt = $crypt;
    }

    /**
     * Returns the challenge
     * 
     * @return string
     */
    public function getChallenge() {

        return $this->_challenge;
    }

    /**
     * Creates a new challenge, stores it in the data store and deletes expired challenges
     * Returns true on success false on failure
     * 
     * @return boolean
     */
    public function createChallenge() {

        $challenge = $this->_crypt->getRandom('challenge');

        if ($challenge !== FALSE) {

            $delete = $this->_deleteOldChallenge(); // first delete older (if any)

            $store = $this->_storeChallenge($challenge);
            if (($delete !== FALSE) && ($store !== FALSE)) {
                $this->_challenge = $challenge;
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    /**
     * Stores the challenge in the data store
     * Returns number of entries created or false on error
     * 
     * @param string $challenge
     * @return mixed
     */
    private function _storeChallenge($challenge) {

        $dataset = 'challenge';
        $values = array(
            'challenge' => $challenge,
            'sessionid' => session_id(),
            'timestamp' => (time() + $this->_configArray['challengeTimedelay'])
        );
        return $this->_dataStore->create($values, $dataset);
    }

    /**
     * Deletes expired challenges from the data store
     * Returns number of entries delted or false on error
     * 
     * @return mixed
     */
    private function _deleteOldChallenge() {

        $dataset = 'challenge';
        $conditions = array(
            array('', 'sessionid', '=', session_id()),
            array('OR', 'timestamp', '<', time())
        );
        return $this->_dataStore->delete($dataset, $conditions);
    }

    /**
     * Feches a Challenge from the datastore and set the _challenge property
     * Returns true on success false on failure
     * 
     * @return boolean
     */
    public function fechChallenge() {
        $field = 'challenge';
        $dataset = 'challenge';
        $conditions = array(
            array('', 'sessionid', '=', session_id()),
            array('AND', 'timestamp', '>', time()),
        );
        $challengeArray = $this->_dataStore->read(array($field), $dataset, $conditions);
        if (!empty($challengeArray)) {
            $this->_challenge = $challengeArray[0][$field];
            return TRUE;
        }
        else
            return FALSE;
    }

}

?>
