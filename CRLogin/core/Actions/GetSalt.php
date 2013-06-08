<?php

/**
 *
 * GetSalt: Executes and controls the 'getSalt' action
 * 
 * 
 * @package CRLogin
 * @subpackage core/Actions
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

namespace CRLogin\core\Actions;

use CRLogin\core\Crypt;
use CRLogin\core\DIC;

class GetSalt implements Actions {

    /**
     * @var DIC 
     */
    private $_container;

    /**
     * @param DIC $container
     */
    public function __construct(DIC $container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguageFile();
    }

    /**
     * Executes the 'getSalt' action
     * Returns a control array for the client side script
     * 
     * @return array
     */
    public function executeAction() {
        $crypt = new Crypt($this->_container);
        $newSalt = $crypt->getNewSalt();
        if ($newSalt === FALSE) {
            return array(
                'error' => TRUE,
                'errorMsg' => ''
            );
        } else {
            $_SESSION['newsalt'] = $newSalt;
            return array('newsalt' => $newSalt);
        }
    }

}

?>
