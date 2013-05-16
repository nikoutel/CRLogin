<?php

class Database extends PDO {

    public $error;

    public function __construct($dsn, $user, $passwd, array $options) {
        try {
            parent::__construct($dsn, $user, $passwd, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

}

?>
