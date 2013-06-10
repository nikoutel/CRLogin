<?php

require 'Debugr/DebugrLoad.php';
if (isset($_POST['lang'])){
    session_start();
    $_SESSION['lang'] = $_POST['lang'];

}
if (isset($_POST['db'])) {
    switch ($_POST['db']) {
        case 'mysql':
            include 'install_form_mysql.php';
            break;
        case 'sqlite3':
            include 'install_form_sqlite3.php';
            break;
        default:
            break;
    }
} 
?>
