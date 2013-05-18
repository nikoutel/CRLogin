<?php
class MySQLDatabase extends Database {

    function __construct($utils, $dsn, $user, $passwd, array $options) {
        parent::__construct($utils, $dsn, $user, $passwd, $options);
    }

}
?>
