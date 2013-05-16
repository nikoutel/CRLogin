<?php

$config = array(
    'disabled' => FALSE, // kill switch
    'dbConfigFile' => 'db_config.php', // kill switch
    'dbOptions' => array(
        'PDO::ATTR_ERRMODE' => ' PDO::ERRMODE_EXCEPTION'
    )
);
return $config;
?>
