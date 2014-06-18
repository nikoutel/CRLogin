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

namespace CRLogin\core;

use CRLogin\core\Crypt;

class GetSalt implements Actions {

    /**
     * @var Crypt 
     */
    private $_crypt;

    /**
     * @param array $languageFile
     * @param Crypt $crypt
     */
    public function __construct($languageFile, Crypt $crypt) {
        
        $this->_l = $languageFile;
        $this->_crypt = $crypt;
    }

    /**
     * Executes the 'getSalt' action
     * Returns a control array for the client side script
     * 
     * @return array
     */
    public function executeAction() {

        $newSalt = $this->_crypt->getNewSalt();
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
