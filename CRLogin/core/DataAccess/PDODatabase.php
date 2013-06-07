<?php

namespace CRLogin\core\DataAccess;
use \PDO;

abstract class PDODatabase implements DataAccessor {

    public $errorMessage;
    public $errorTraceAsString;
    public $pdo;
    private $_utils;
    private $_dsn;
    private $_databaseDriver;
    private $_user;
    private $_password;
    private $_host;
    private $_port;
    private $_dbName;
    private $_options;
    private $_dbPath;

    public function __construct(array $dbParameters, $utils) {
        $this->_utils = $utils;
        $this->setParameters($dbParameters);

        $this->connect($this->_dsn, $this->_user, $this->_password, $this->_options);
    }

    public function setParameters($dbParameters) {
        $this->_options = $dbParameters['dbOptions'];

        $this->_databaseDriver = strtolower($dbParameters['databaseDriver']);
        if ($this->_databaseDriver == 'mysql') {
            $this->_user = $dbParameters['username'];
            $this->_password = $dbParameters['password'];


            $this->_host = $dbParameters['host'];
            $this->_dbName = $dbParameters['dbName'];
            if ($dbParameters['port'] != '') {
                $this->_port = $dbParameters['port'];
            } else {
                $this->_port = '3306';
            }

            $this->_dsn = 'mysql:host=' . $this->_host . ';port=' . $this->_port . ';dbname=' . $this->_dbName;
        }
        if ($this->_databaseDriver == 'sqlite') {
            $this->_dbPath = $dbParameters['dbPath'];
            $this->_dsn = 'sqlite:' . $this->_dbPath;
        }
    }

    public function connect($dsn, $username, $passwd, $options) {
        try {
            $this->pdo = new PDO($dsn, $username, $passwd, $options);
        } catch (PDOException $exc) {
            $this->errorMessage = $exc->getMessage();
            $this->errorTraceAsString = $exc->getTraceAsString();
            echo $this->errorMessage; // delme
            return FALSE;
        }
    }

    abstract protected function _getTables();
    abstract protected function _getColumns($tableName, $withPrimaryKey);

    public function create(array $values, $table) {
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
            $conditions = $this->_getConditions($conditions);
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
            if ($key != (count($columns) - 1)) {
                $sql .= ', ';
            }
        }
        if (!empty($conditions)) {
            $conditions = $this->_getConditions($conditions);
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
        $sql = 'DELETE FROM ' . $table;
        if (!empty($conditions)) {
            $conditions = $this->_getConditions($conditions);
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
//        Debugr::edbgLog($sql, '$sql');

//        Debugr::edbgLog($bind, '$bind');

        if ($this->pdo != null) {
            try {
                $stmt = $this->pdo->prepare($sql);
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
            } catch (PDOException $exc) {
                $this->errorMessage = $exc->getMessage();
                $this->errorTraceAsString = $exc->getTraceAsString();
                echo $this->errorMessage; // delme
                return FALSE;
            }   
                }
        else
            return FALSE;
    }

    public function runQuery($query) {
        if ($this->pdo != null) {
            try {
                if ($this->_isDataRetrievalOperation($query)) {
                    $stmt = $this->pdo->query($query);
                    if ($stmt) {
                        return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    else
                        return FALSE;
                } else {
                    return $this->pdo->exec($query);
                }
            } catch (PDOException $exc) {
                $this->errorMessage = $exc->getMessage();
                $this->errorTraceAsString = $exc->getTraceAsString();
                echo $this->errorMessage; // delme
                return FALSE;
            }
        }
        else
            return FALSE;
    }

    protected function _getConditions(array $conditions) {

        $leafprev = '';
        $bind = array();
        $sqlWhere = '';
        if (count($conditions) != count($conditions, 1)) { // if conditions array is multidimensional
            $depth = 1;
            $conditions = array_merge($conditions, array(array(''))); // adds a empty array at the end so the dept is counted until the end
        } else {
            $depth = 0;
        }
        $iterator = new \RecursiveIteratorIterator(
                new \RecursiveArrayIterator($conditions), \RecursiveIteratorIterator::LEAVES_ONLY
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
                } else {
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

    protected function _isDataRetrievalOperation($query) {
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
