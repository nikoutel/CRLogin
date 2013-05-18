<?php
// !!! the folder the database resides in must have write permissions, as well as the actual database file.
class SQLiteDatabase extends Database {

    function __construct($utils, $dsn, $user, $passwd, $options) {
        parent::__construct($utils, $dsn, $user, $passwd, $options);
    }

}

?>
