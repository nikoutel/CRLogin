<?php

class MySQLDatabase extends PDODatabase {

    function __construct(array $dbParameters, $utils) {
        parent::__construct($dbParameters, $utils);
    }

    protected function _getTables() {
        $sqlQuery = "SHOW TABLES";
        
        $array = $this->runQuery($sqlQuery);
        foreach ($array as $value) {
            $tables[] = $value[key($value)];
        }
        return $tables;
    }

    protected function _getColumns($tableName, $showPrimaryKey = FALSE) {
        if (in_array($tableName, $this->_getTables())) {
            $sqlQuery = "SHOW COLUMNS FROM " . $tableName;
            
            $array = $this->runQuery($sqlQuery);
            foreach ($array as $value) {
                if (($showPrimaryKey) || ($value['Key']) != 'PRI') {
                    reset($value);
                    $columns[] = $value[key($value)];
                }
            } return $columns;
        } else
            return FALSE;
    }

}

?>
