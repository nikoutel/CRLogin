<?php

class MySQLDatabase extends Database {

    function __construct($utils, $dsn, $user, $passwd, array $options) {
        parent::__construct($utils, $dsn, $user, $passwd, $options);
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
