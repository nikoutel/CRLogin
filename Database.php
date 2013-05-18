<?php

class Database extends PDO {

    public $error;
    private $_utils;

    public function __construct($utils, $dsn, $user, $passwd, array $options) { //@todo connect method
        $this->_utils = $utils;
        try {
            parent::__construct($dsn, $user, $passwd, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function create($table,  $values) {
        if ($this->_utils->isAssociative($values)) {
            $columns = array_keys($values);
            $bind = array_values($values);
            $columns_str = '(' . implode(",", $columns) . ')';
        } else {
            $bind = $values;
            $columns_str = ''; //@FIXME
        }

        $sql = 'INSERT INTO ' . $table . ' ' . $columns_str;
        $sql .= 'VALUES (';
        $n =count($values);
        for ($index = 1; $index <= $n; $index++) {
            $sql .= '?';
            if ($index != $n) $sql .= ', ';
        };
        $sql .= ');';
        Debugr::edbg($sql, '$sql');
        Debugr::edbg($bind, '$bind', 'r');
        $result = $this->execute($sql, $bind);
        return $result;
        }

    public function read(array $columns, $table, array $conditions = array()) {
        $columns_str = implode(",", $columns);
        if (strtolower($columns_str) == 'all') {
            $columns_str = '*';
        }
        $conditions = $this->getConditions($conditions);
        $sqlWhere = $conditions['sqlWhere'];
        $bind = $conditions['bind'];
        $sql = 'SELECT ' . $columns_str . ' FROM ' . $table;
        if (!empty($sqlWhere)) {
            $sql .= ' WHERE ' . $sqlWhere;
        }
        $sql .= ";";
        $result = $this->execute($sql, $bind);
        return $result;
    }

    public function update($param) {
        
    }

    //delete from chre where sess_id = '" . session_id() . "'")
    //DELETE FROM chre WHERE sess_id = "' . session_id() . '" or timestamp <' . time();
    public function delete($param) {
        
    }

    public function execute($sql, array $bind) {
        try {
            $stmt = $this->prepare($sql);
            $stmt->execute($bind);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); //FIXME
        } catch (Exception $exc) {
            $this->error = $exc->getTraceAsString();
            Debugr::edbg($this->error, '$this->error');

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
                $sqlWhere .= $leaf . ' ';
            }
            $leafprev = $leaf;
        }
        return array(
            'sqlWhere' => $sqlWhere,
            'bind' => $bind
        );
    }

}

?>
