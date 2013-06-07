<?php

use CRLogin\core\DIC;
use CRLogin\core\Crypt;

require 'Debugr/DebugrLoad.php';
require $base . '/CRLoginAutoloader.php';


$dic = new DIC;
$l = $dic->getLanguageFile();
$session = $dic->startSession();
$_SESSION ['members'] = FALSE;
$_SESSION['redirectURL'] = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

function getToken($dic) {
    $crypt = new Crypt($dic);
    $token = $crypt->getRandom('challenge');
    $_SESSION['token'] = $token;
    return $token;
}

?>
