<?php

/**
 *
 * DatabaseDrivers: Enumerates the database driver options
 * 
 * 
 * @package CRLogin
 * @subpackage DataAccess
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

namespace CRLogin\DataAccess;

final Class DatabaseDrivers {

    const MySQL = 'MySQL';
    const SQLite = 'SQLite';

    private function __construct() {
        
    }

}

?>
