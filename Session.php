<?php

class Session {

    protected $_db;
    protected $_utils;

    public function __construct($db, $utils) {
        $this->_db = $db;
        $this->_utils = $utils;
        register_shutdown_function('session_write_close');
        session_set_save_handler(
                array($this, "open"),
                array($this, "close"),
                array($this, "read"),
                array($this, "write"),
                array($this, "destroy"),
                array($this, "gc")
        );
session_start();
    }

    function open($save_path, $session_name) {
        return TRUE;
    }

    function close() {
        return TRUE;
    }

    function read($id) {
        $conditions = array('', 'id', '=', $id);
        $field = array('data');
        return $this->_db->read($field, 'sessions', $conditions);
    }

    function write($id, $data) {

        $field = array('id');
        $id_arr = $this->_db->read($field, 'sessions');
        $access = time();
        $values = array('id' => $id, 'access' => $access, 'data' => $data);

        if ($this->_utils->in_array_recursive($id, $id_arr)) {

            $conditions = array('', 'id', '=', $id);
            return $this->_db->update($values, 'sessions', $conditions);
        } else {
            return $this->_db->create($values, 'sessions');
        }
    }

    function destroy($id) {
        $conditions = array('', 'id', '=', $id);
        return $this->_db->delete('sessions', $conditions);
    }

    function garbageCollector($maxlifetime) {
        $old = time() - $maxlifetime;
        $conditions = array('', 'access', '<', $old);
        return $this->_db->delete('sessions', $conditions);
    }

}

?>
