<?php

class Session {

    protected $_dataStore;
    protected $_utils;

    public function __construct($dataStore, $utils) {
        $this->_dataStore = $dataStore;
        $this->_utils = $utils;
        register_shutdown_function('session_write_close');
        session_set_save_handler(
                array($this, "open"), array($this, "close"), array($this, "read"), array($this, "write"), array($this, "destroy"), array($this, "garbageCollector")
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
        $return = $this->_dataStore->read($field, 'sessions', $conditions);
        if (!empty($return))
            return $return[0]['data'];
        else
            return '';
    }

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

    function destroy($id) {
        $conditions = array('', 'id', '=', $id);
        return $this->_dataStore->delete('sessions', $conditions);
    }

    function garbageCollector($maxlifetime) {
        $old = time() - $maxlifetime;
        $conditions = array('', 'access', '<', $old);
        return $this->_dataStore->delete('sessions', $conditions);
    }

}

?>
