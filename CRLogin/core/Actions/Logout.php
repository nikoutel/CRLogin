<?php

/**
 *
 * Logout: Executes and controls the 'logout' action
 *
 *
 * @package CRLogin
 * @subpackage core/Actions
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013-2019 Nikos Koutelidis
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin
 *
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 *
 */

namespace CRLogin\core\Actions;


class Logout implements Actions {


    /**
     *
     */
    public function __construct() {

    }

    /**
     * Executes the 'logout' action
     * Returns a control array for the client side script
     *
     * @param $destroySession bool
     * @return array
     */
    public function executeAction($destroySession = false) {
        if (isset($_SESSION['redirectURL']) && (!$_SESSION ['members'])) {
            $redirectURL = $_SESSION['redirectURL'];
            unset($_SESSION['redirectURL']);
        } else {
            $redirectURL = LOGIN_FORM_REQUEST_URI;
        }

        $_SESSION['logged'] = false;
        $_SESSION['username'] = false;
        unset($_SESSION['token']);

        if ($destroySession) {
            $this->destroySession();
        }
        return array(
            'redirect' => TRUE,
            'redirectURL' => $redirectURL);
    }


    /**
     * Clears the session data and destroys the session
     *
     * @return bool
     */
    public function destroySession() {

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        return session_destroy();
    }
}
?>
