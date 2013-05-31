<?php

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';
$dic = new DIC;
$session = $dic->startSession();
if (isset($_SESSION['redirectURL']) && (!$_SESSION ['members'])) {
    $redirectURL=$_SESSION['redirectURL'];
    unset($_SESSION['redirectURL']);
} else {
     $redirectURL='/index.php';
}

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

session_destroy();
header('location: ' . $redirectURL);
?>
