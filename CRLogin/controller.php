<?php

namespace CRLogin;

use CRLogin\core\DIC;

require 'CRLoginAutoloader.php';
require 'Debugr/DebugrLoad.php';

$dic = new DIC;
$session = $dic->startSession();
if (isset($_POST['action'])) {
    if (((isset($_POST['token'])) && ($_POST['token'] == $_SESSION['token'])) || ($_POST['action']) == 'logout') {
        try {
            $action = strtolower($_POST['action']);
            $className = 'Actions_' . implode("", array_map('ucfirst', explode('_', $action)));
            $controller = new $className($dic);
            echo json_encode($controller->executeAction());
        } catch (Exception $e) {
            header('404 Not Found');
            exit;
        }
    }
}
?>