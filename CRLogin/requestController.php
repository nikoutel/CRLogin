<?php

/**
 *
 * requestController.php
 * Controls  and handles all the POST requests.
 * 
 * 
 * @package CRLogin
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013 Nikos Koutelidis 
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin 
 * 
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 */

namespace CRLogin;

use CRLogin\core\DIC;

require '../CRLoginAutoloader.php';


$dic = new DIC;
$session = $dic->getSession();
if (isset($_POST['action'])) {
    if (((isset($_POST['token'])) && ($_POST['token'] == $_SESSION['token'])) || ($_POST['action']) == 'logout') {
        try {
            $action = strtolower($_POST['action']);
            $className = 'CRLogin\core\\' . implode("", array_map('ucfirst', explode('_', $action)));
            $controller = $dic->getObject($className);
            echo json_encode($controller->executeAction());
        } catch (Exception $e) {
            header('404 Not Found');
            exit;
        }
    }
}
?>