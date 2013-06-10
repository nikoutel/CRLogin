<?php

/**
 *
 * SQLiteDatabase: An extension to the database class.
 * Provides SQLite specific methods 
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

// !!! the folder the database resides in must have write permissions, as well as the actual database file.
class SQLiteDatabase extends PDODatabase {

    function __construct(array $dbParameters, $utils) {
        parent::__construct($dbParameters, $utils);
    }

    /**
     * A SQLite specific method
     * Returns the database tables
     *
     * @return array
     */
    protected function _getTables() {
        $sqlQuery = "SELECT name FROM
                    (SELECT * FROM sqlite_master UNION ALL
                    SELECT * FROM sqlite_temp_master)
                    WHERE type='table'
                    ORDER BY name";

        $array = $this->runQuery($sqlQuery);
        foreach ($array as $value) {
            $tables[] = $value[key($value)];
        }
        return $tables;
    }

    /**
     * A SQLite specific method.
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
            $sqlQuery = "PRAGMA table_info('" . $tableName . "');";

            $array = $this->runQuery($sqlQuery);
            foreach ($array as $value) {
                if (($withPrimaryKey) || ($value['pk']) != '1') {
                    $columns[] = $value['name'];
                }
            }
            return $columns;
        }
        else
            return FALSE;
    }

}

?>
