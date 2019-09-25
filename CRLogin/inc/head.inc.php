<?php 

/**
 *
 * head.inc
 * Include file to be included in the <head> section
 * 
 * 
 * @package CRLogin
 * @subpackage inc
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

$url = htmlspecialchars(CRL_APP_URL_PATH . CRL_APP_DIR);
?>
    <script>
        if (typeof jQuery === 'undefined') {
            document.write(unescape("%3Cscript src='<?= $url ?>/scripts/jquery-1.7.1.min.js' type='text/javascript'%3E%3C/script%3E"));
        }
    </script>
    <script src="<?= $url ?>/scripts/msg.js.php"></script>
    <script src="<?= $url ?>/scripts/jBCrypt/bCrypt.js"></script>
    <script src="<?= $url ?>/scripts/sha256.js"></script>
    <script src="<?= $url ?>/scripts/scripts.js"></script>
