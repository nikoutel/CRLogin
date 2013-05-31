<?php

// !!! the folder the database resides in must have write permissions, as well as the actual database file.
class SQLiteDatabase extends PDODatabase {

    function __construct(array $dbParameters, $utils) {
        parent::__construct($dbParameters, $utils);
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
