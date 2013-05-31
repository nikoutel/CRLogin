<?php
require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$session = $dic->startSession();
$l=$dic->getLanguage();
$_SESSION ['members'] = TRUE;
$_SESSION['redirectURL'] = '//'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)) {
    header('Location:index.php?s=login');
    die();
}
?>
