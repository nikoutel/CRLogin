<?php

$config = array(
    'general' => array(
        'disabled' => 'FALSE', // kill switch
        'datastore' => 'database',
        'dbConfigFile' => 'db_config0.php'
    ),
    'db' => array(
        'dbOptions' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    )
);
return $config;
?>
