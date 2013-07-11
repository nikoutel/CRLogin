<?php

/**
 *
 * Session: Session handler
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

class Session {

    /**
     * @var resource 
     */
    protected $_dataStore;

    /**
     * @var Utils 
     */
    protected $_utils;

    /**
     * Initializes the session. If sessionInDataStore is true,
     * user-level session storage functions are called for storing sessionn 
     * data in data store.
     * 
     * @param resource $dataStore
     * @param array $configuration
     * @param Utils $utils
     */
    public function __construct($dataStore, $configuration, $utils) {
        $this->_dataStore = $dataStore;
        $this->_utils = $utils;
        if ($configuration['sessionInDataStore']) {

            register_shutdown_function('session_write_close'); /* Calling the 'write' and 'close' handlers before the session object is destroyed */
            session_set_save_handler(
                    array($this, "open"), array($this, "close"), array($this, "read"), array($this, "write"), array($this, "destroy"), array($this, "garbageCollector")
            );
        }
        session_start();
    }

    /**
     * Wrapper for the open callback
     * 
     * @param string $save_path
     * @param string $session_name
     * @return boolean
     */
    function open($save_path, $session_name) {
        return TRUE;
    }

    /**
     * Wrapper for the close callback
     * 
     * @return boolean
     */
    function close() {
        return TRUE;
    }

    /**
     * Wrapper for the read callback
     * 
     * @param int $id
     * @return string
     */
    function read($id) {
        $conditions = array('', 'id', '=', $id);
        $field = array('data');
        $return = $this->_dataStore->read($field, 'sessions', $conditions);
        if (!empty($return))
            return $return[0]['data'];
        else
            return '';
    }

    /**
     * Wrapper for the write callback
     * 
     * @param int $id
     * @param mixed $data
     * @return mixed
     */
    function write($id, $data) {
        $field = array('id');
        $id_arr = $this->_dataStore->read($field, 'sessions');
        $access = time();
        $values = array('id' => $id, 'access' => $access, 'data' => $data);

        if ($this->_utils->in_array_recursive($id, $id_arr)) {

            $conditions = array('', 'id', '=', $id);
            return $this->_dataStore->update($values, 'sessions', $conditions);
        } else {
            return $this->_dataStore->create($values, 'sessions');
        }
    }

    /**
     * Wrapper for the destroy callback
     * 
     * @param int $id
     * @return mixed
     */
    function destroy($id) {
        $conditions = array('', 'id', '=', $id);
        return $this->_dataStore->delete('sessions', $conditions);
    }

    /**
     * Wrapper for the gc callback
     * 
     * @param int $maxlifetime
     * @return mixed
     */
    function garbageCollector($maxlifetime) {
        $old = time() - $maxlifetime;
        $conditions = array('', 'access', '<', $old);
        return $this->_dataStore->delete('sessions', $conditions);
    }

}

?>
