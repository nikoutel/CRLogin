<?php

$config = array(
    'general' => array(
        'disabled' => 'FALSE', // kill switch
        'datastore' => 'database',
        'dbConfigFile' => realpath($_SERVER["DOCUMENT_ROOT"]) .'/CRLogin/config/install_config10.php',
        'challengeTimedelay' => 15, //number of seconds the challenge is stored in the database
        'sessionInDB' => TRUE,
        'cryptCostParameter' => '10'
    ),
    'db' => array(
        'dbOptions' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    )
);
return $config;
?>
