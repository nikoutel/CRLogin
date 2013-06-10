<?php

/**
 *
 * MySQLDatabase: An extension to the database class.
 * Provides MySQL specific methods 
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

class MySQLDatabase extends PDODatabase {

    /**
     *
     * @param array $dbParameters
     * @param Utils $utils
     */
    function __construct(array $dbParameters, $utils) {
        parent::__construct($dbParameters, $utils);
    }

    /**
     * A MySQL specific method
     * Returns the database tables
     *
     * @return array
     */
    protected function _getTables() {
        $sqlQuery = "SHOW TABLES";

        $array = $this->runQuery($sqlQuery);
        foreach ($array as $value) {
            $tables[] = $value[key($value)];
        }
        return $tables;
    }

    /**
     * A MySQL specific method
     * Returns the columns of table $tableName
     *
     * If $withPrimaryKey is true the primary key is also included.
     * Default is false
     *
     * @param string $tableName
     * @param boolean $withPrimaryKey
     * @return mixed
     */
    protected function _getColumns($tableName, $withPrimaryKey = FALSE) {
        if (in_array($tableName, $this->_getTables())) {
            $sqlQuery = "SHOW COLUMNS FROM " . $tableName;

            $array = $this->runQuery($sqlQuery);
            foreach ($array as $value) {
                if (($withPrimaryKey) || ($value['Key']) != 'PRI') {
                    reset($value);
                    $columns[] = $value[key($value)];
                }
            } return $columns;
        }
        else
            return FALSE;
    }

}

?>
