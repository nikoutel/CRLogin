<?php

$config = array(
    'general' => array(
        'disabled' => 'FALSE', // kill switch
        'datastore' => 'database',
        'dbConfigFile' => 'db_config0.php',
        'challengeTimedelay' => 15, //number of seconds the challenge is stored in the database
    ),
    'db' => array(
        'dbOptions' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    )
);
return $config;
?>
