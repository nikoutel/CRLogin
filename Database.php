<?php

class Database extends PDO {

    public $error;
    private $_utils;
    private $_dsn;
    private $_user;
    private $_password;
    private $_options;

    public function __construct($utils, $dsn, $user, $passwd, array $options) { //@todo connect method
        $this->_utils = $utils;
        $this->_dsn = $dsn;
        $this->_user = $user;
        $this->_password = $passwd;
        $this->_options = $options;

        $this->connect($this->_dsn, $this->_user, $this->_password, $this->_options);
    }

    public function connect($dsn, $username, $passwd, $options) {
        try {
            parent::__construct($dsn, $username, $passwd, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage(); //@ FIXME
            Debugr::edbg($this, '$this');

            Debugr::edbg($e->getMessage(), '$e->getMessage()', 'v');
            Debugr::edbg($this->error, '$this->error');
            return FALSE;
        }
    }

    public function create($table, $values) {
        if ($this->_utils->isAssociative($values)) {
            $columns = array_keys($values);
            $bind = array_values($values);
        } else {
            $columns = $this->_getColumns($table);
            $bind = $values;
            if (count($columns) != (count($bind)))
                return FALSE;
        }
        $columns_str = '(' . implode(",", $columns) . ')';
        $sql = 'INSERT INTO ' . $table . ' ' . $columns_str;
        $sql .= 'VALUES (';
        $n = count($values);
        for ($index = 1; $index <= $n; $index++) {
            $sql .= '?';
            if ($index != $n)
                $sql .= ', ';
        };
        $sql .= ');';
        $result = $this->execute($sql, $bind);
        return $result;
    }

    public function read(array $columns, $table, array $conditions = array()) {
        $columns_str = implode(",", $columns);
        if (strtolower($columns_str) == 'all') {
            $columns_str = '*';
        }
        $bind = array();
        $sql = 'SELECT ' . $columns_str . ' FROM ' . $table;
        if (!empty($conditions)) {
            $conditions = $this->getConditions($conditions);
            $sqlWhere = $conditions['sqlWhere'];
            $bind = $conditions['bind'];
            if (!empty($sqlWhere)) {
                $sql .= ' WHERE ' . $sqlWhere;
            }
        }
        $sql .= ";";
        $result = $this->execute($sql, $bind);
        return $result;
    }

    public function update(array $values, $table, array $conditions = array()) {
        
        $columns = array_keys($values);
        $bindSet = array_values($values);
        $sql = 'UPDATE ' . $table . ' SET ';
        
        foreach ($columns as $key => $value) {
            $sql .= $value . '=?';
            if ($key != (count($columns)-1)){
                $sql .= ', ';
            }
        }
        if (!empty($conditions)) {
            $conditions = $this->getConditions($conditions);
            $sqlWhere = $conditions['sqlWhere'];
            $bindConditions = $conditions['bind'];
            if (!empty($sqlWhere)) {
                $sql .= ' WHERE ' . $sqlWhere;
            }
        }
        $sql .= ";";
        $bind = array_merge($bindSet, $bindConditions);
        $result = $this->execute($sql, $bind);
        return $result;
        
    }

    public function delete($table, array $conditions = array()) {
        $bind = array();
        $sql='DELETE FROM ' . $table;
        if (!empty($conditions)) {
            $conditions = $this->getConditions($conditions);
            $sqlWhere = $conditions['sqlWhere'];
            $bind = $conditions['bind'];
            if (!empty($sqlWhere)) {
                $sql .= ' WHERE ' . $sqlWhere;
            }
        }
        $sql .= ";";
        $result = $this->execute($sql, $bind);
        return $result;
    }

    public function execute($sql, array $bind) {
        try {
            $stmt = $this->prepare($sql);
            $stmt->execute($bind);
            if ($stmt) {
                if ($this->_isDataRetrievalOperation($sql)) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return $stmt->rowCount();
                }
            }
            else
                return FALSE;
        } catch (Exception $exc) {
            $this->error = $exc->getTraceAsString();
            Debugr::edbg($this->error, '$this->error');

            return FALSE;
        }
    }

    public function runQuery($query) {

        try {
            if ($this->_isDataRetrievalOperation($query)) {
                $stmt = $this->query($query);
                if ($stmt) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                else
                    return FALSE;
            } else {
                return $this->exec($query);
            }
        } catch (Exception $exc) {
            $this->error = $exc->getTraceAsString();
            return FALSE;
        }
    }

    public function getConditions(array $conditions) {
        $depth = 1;
        $leafprev = '';
        $bind = array();
        $sqlWhere = '';
        $conditions = array_merge($conditions, array(array(''))); // adds a empty array at the end so the dept is counted until the end
        $iterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator($conditions), RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($iterator as $key => $leaf) {
            $depthold = $depth;
            $depth = $iterator->getDepth();
            if ($depth > $depthold) {

                for ($index = 0; $index < $depth - $depthold; $index++) {
                    $sqlWhere .= '(';
                }
            }
            if ($depth < $depthold) {
                for ($index = 0; $index < $depthold - $depth; $index++) {
                    $sqlWhere .= ') ';
                }
            }
            if ($key == 3) {
                $sqlWhere .= '? ';
                $bind[] = $leaf;
            } else {
                if ($key == 0) {
                    $sqlWhere .= $leaf . ' ';
                }  else {
                    $sqlWhere .= $leaf;
                }
            }
            $leafprev = $leaf;
        }
        return array(
            'sqlWhere' => $sqlWhere,
            'bind' => $bind
        );
    }

    private function _isDataRetrievalOperation($query) {
        echo
        $is = FALSE;
        $dataRetrievalQuerySet = array('SELECT', 'SHOW', 'DESCRIBE', 'PRAGMA');
        foreach ($dataRetrievalQuerySet as $value) {
            $is = ($is or $this->_utils->startsWith($query, $value));
        }
        return $is;
    }

}

?>
