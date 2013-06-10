<?php

/**
 *
 * PDODatabase: abstract; A data access layer class built around PHPs data object 
 * 
 * 
 * @package CRLogin
 * @subpackage core/Data Access
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

namespace CRLogin\core\DataAccess;

use \PDO;

abstract class PDODatabase implements DataAccessor {

    /**
     * @var string 
     */
    public $errorMessage;

    /**
     * @var string 
     */
    public $errorTraceAsString;

    /**
     * @var PDO 
     */
    public $pdo;

    /**
     * @var Utils 
     */
    private $_utils;

    /**
     * @var string 
     */
    private $_dsn;

    /**
     * @var string 
     */
    private $_databaseDriver;

    /**
     * @var string 
     */
    private $_user;

    /**
     * @var string 
     */
    private $_password;

    /**
     * @var string 
     */
    private $_host;

    /**
     * @var string 
     */
    private $_port;

    /**
     * @var string 
     */
    private $_dbName;

    /**
     * @var array 
     */
    private $_options;

    /**
     * @var string 
     */
    private $_dbPath;

    /**
     * 
     * @param array $dbParameters
     * @param Utils $utils
     */
    public function __construct(array $dbParameters, $utils) {
        $this->_utils = $utils;
        $this->setParameters($dbParameters);

        $this->connect($this->_dsn, $this->_user, $this->_password, $this->_options);
    }

    /**
     * Sets the database driver, user, password, host, dbname, port, dppath
     * Prepares the PDOs Data Source Name 
     * 
     * @param array $dbParameters
     */
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

    /**
     * Instantiates a PHP Data Object and connects to the databasae
     * 
     * @param string $dsn
     * @param string $username
     * @param string $passwd
     * @param array $options
     * @return boolean
     */
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

    /**
     * Abstract method for geting the database tables
     * Database driver specific
     */
    abstract protected function _getTables();

    /**
     * Abstract method for geting the database columns
     * Database driver specific
     */
    abstract protected function _getColumns($tableName, $withPrimaryKey);

    /**
     * Creates entries in the database
     * 
     * @param array $values 
     *  If an associative array is given the keys will be the fields/columns, 
     * and the array values the field values.
     * If an numeric array is given, the method will try 
     * to associate the array values to the field values
     * in order of the fields/columns when the dataset/table was created
     * 
     * @param string $tables The dataset/table to store the values
     */
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

    /**
     * Reads entries from the database
     * 
     * @param array $columns An array with the fields/columns to read
     * 
     * @param string $table The dataset/table to read from
     * 
     * @param array $conditions
     * An array representing the logical conditions. Each level is represented by an array with the form:
     * array('LOGICAL_OPARATOR' , 'FIELD' , 'OPARATOR' , 'VALUE')
     * On a simple condition like : (id = '10') 
     * the array would be : array('' , 'id' , '=' , '10').
     * A more complex example:  (Country = 'Germany' AND (city = 'Berlin' OR City = 'Muenchen'))
     * array(
     *      array('', 'Country', '=', 'Germany'),
     *      array('AND',
     *           array(
     *                array('', 'city', '=', 'Berlin'),
     *                array('OR', 'city', '=', 'Muenchen')
     *           )
     *      )
     * )
     */
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

    /**
     * Updates entries from the database
     * 
     * @param array $values
     *  If an associative array is given the keys will be the fields/columns, 
     * and the array values the field values.
     * If an numeric array is given, the method will try 
     * to associate the array values to the field values
     * in order of the fields/columns when the dataset/table was created
     * 
     * @param string $table The dataset/table to be updated
     * 
     * @param array $conditions
     *  An array representing the logical conditions. Each level is represented by an array with the form:
     * array('LOGICAL_OPARATOR' , 'FIELD' , 'OPARATOR' , 'VALUE')
     * On a simple condition like : (id = '10') 
     * the array would be : array('' , 'id' , '=' , '10').
     * A more complex example:  (Country = 'Germany' AND (city = 'Berlin' OR City = 'Muenchen'))
     * array(
     *      array('', 'Country', '=', 'Germany'),
     *      array('AND',
     *           array(
     *                array('', 'city', '=', 'Berlin'),
     *                array('OR', 'city', '=', 'Muenchen')
     *           )
     *      )
     * )
     */
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

    /**
     * Deletes entries from the database
     * 
     * @param string $table The dataset/table to be deleted
     * 
     * @param array $conditions
     *  An array representing the logical conditions. Each level is represented by an array with the form:
     * array('LOGICAL_OPARATOR' , 'FIELD' , 'OPARATOR' , 'VALUE')
     * On a simple condition like : (id = '10') 
     * the array would be : array('' , 'id' , '=' , '10').
     * A more complex example:  (Country = 'Germany' AND (city = 'Berlin' OR City = 'Muenchen'))
     * array(
     *      array('', 'Country', '=', 'Germany'),
     *      array('AND',
     *           array(
     *                array('', 'city', '=', 'Berlin'),
     *                array('OR', 'city', '=', 'Muenchen')
     *           )
     *      )
     * )
     */
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

    /**
     * Executes the prepared statemend $sql with $bind parameters
     * 
     * Returns the values requested (in a two dimensinal array) for data 
     * retrieval operation (SELECT, SHOW, DESCRIBE, PRAGMA), 
     * the affected rows for all others,
     * or false on failure
     * 
     * @param string $sql The sql statemend 
     * @param array $bind The bind parameters array
     * @return mixed
     */
    public function execute($sql, array $bind) {

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

    /**
     * Executes an sql query
     * 
     * This method does not add security measures, like escaping
     * The caller should make sure that the query is safe
     * 
     * Returns the values requested (in a two dimensinal array) for data
     * retrieval operation (SELECT, SHOW, DESCRIBE, PRAGMA), 
     * the affected rows for all others,
     * or false on failure
     * 
     * @param string $query The sql query
     * @return mixed
     */
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

    /**
     * Forms the 'where' clause from a conditions array
     * Returns the sql statement and the bind conditions in an array
     * 
     * @param array $conditions
     * @return array
     */
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

    /**
     * Checks if an oparation  is data retrieval i.e. if sql statements 
     * start with one of {SELEC, SHOW, DESCRIBE, PRAGMA}
     * 
     * @param string $query
     * @return boolean
     */
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
