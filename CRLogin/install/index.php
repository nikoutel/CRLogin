<?php
session_start();
ini_set('display_errors', 0);

if ($_SERVER['QUERY_STRING'] == '') {
    $installScriptName = basename(__FILE__);
} else {
    $installScriptName = basename(__FILE__) . '?' . $_SERVER['QUERY_STRING'];
}
$_SESSION['installScriptName'] = $installScriptName;

if ((!isset($_GET['s'])) || ($_GET['s'] !== 'form')) {

    include 'install.php';
} else {
    include 'install_form.php';
}
?>
