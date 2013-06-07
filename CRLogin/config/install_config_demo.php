<?php

$db_config = array(
    'db' => array(
        'databaseDriver' => DatabaseDrivers::MySQL,
        'host' => 'localhost',
        'dbName' => 'logindb',
        'username' => 'rootuser',
        'password' => 'pass',
        'port' => '3306',
        'dbOptions' => array(
        )
    ),
    'general' => array(
        'language' => 'en'
    )
);
//$db_config = array(
//    'db' => array(
//        'databaseDriver' => DatabaseDrivers::SQLite,
//        'dbPath' => '/path/to/sqlite/db.sq3',
//        'username' => NULL,
//        'password' => NULL,
//        'dbOptions' => array(
//        )
//    ),
//    'general' => array(
//        'language' => 'en'
//    )
//);
return $db_config;
?>
