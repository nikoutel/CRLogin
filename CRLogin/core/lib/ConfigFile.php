<?php

/**
 *
 * ConfigFile: Reads a configuration file and returns its configuration array
 * 
 * 
 * @package CRLogin
 * @subpackage core\lib
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

namespace CRLogin\core\lib;


class ConfigFile {

    /**
     * Returns a configuration array from a configuration file
     * or false on failure
     * 
     * @param string $file
     * @return mixed
     */
    public function readFile($file) {
        if (is_file($file)) {
            $arr = include $file;
            return $arr;
        } else {
            return FALSE;
        }
    }

}

?>
