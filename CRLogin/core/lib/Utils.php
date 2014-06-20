<?php

/**
 *
 * Utils: A utility method collection
 * 
 * 
 * @package CRLogin
 * @subpackage core\lib
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

namespace CRLogin\core\lib;

class Utils {

    /**
     * Checks if an array is associative
     * 
     * @param array $array
     * @return bool
     */
    public function isAssociative($array) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

    /**
     * Checks if $haystack starts with $needle
     * 
     * @param string $haystack
     * @param string $needle
     * @return boolean
     */
    public function startsWith($haystack, $needle) {
        return !strncasecmp($haystack, $needle, strlen($needle));
    }

    /**
     * Checks the array $heystack recursively for $needle
     * 
     * @param type $needle
     * @param type $haystack
     * @return boolean
     */
    public function in_array_recursive($needle, $haystack) {
        foreach ($haystack as $item) {
            if (($item == $needle) || (is_array($item) && $this->in_array_recursive($needle, $item))) {
                return true;
            }
        }
        return false;
    }

}

?>
