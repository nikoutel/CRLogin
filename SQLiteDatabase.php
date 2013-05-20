<?php

// !!! the folder the database resides in must have write permissions, as well as the actual database file.
class SQLiteDatabase extends Database {

    function __construct($utils, $dsn, $user, $passwd, $options) {
        parent::__construct($utils, $dsn, $user, $passwd, $options);
    }

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

    protected function _getColumns($tableName, $showPrimaryKey = FALSE) {
        if (in_array($tableName, $this->_getTables())) {
            $sqlQuery = "PRAGMA table_info('" . $tableName . "');";

            $array = $this->runQuery($sqlQuery);
            foreach ($array as $value) {
                if (($showPrimaryKey) || ($value['pk']) != '1') {
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
