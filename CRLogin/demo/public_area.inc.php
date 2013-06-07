<?php

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$l=$dic->getLanguage();
$session = $dic->startSession();
$_SESSION ['members'] = FALSE;
$_SESSION['redirectURL'] = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
