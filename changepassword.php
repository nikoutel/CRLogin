<?php
require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$session = $dic->startSession();
if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)){
    header('Location:index.php?s=login');
    die();
}
echo 'cp';

?>
<br />
<a href="index.php?s=logout">Logout</a>