<?php
require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$session = $dic->startSession();
if (!isset($_SESSION['logged']) || ($_SESSION['logged'] === FALSE)){
    header('Location:index.php?s=login');
    die();
}
echo 'hello member ';
echo $_SESSION['username'];
?>
<br />
<a href="index.php?s=logout">Logout</a><br />
<a href="index.php?s=changepassword">Change Password</a><br />
