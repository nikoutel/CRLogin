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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>       
<script type="text/javascript">
    var l = <?php echo json_encode(CRLogin::$l); ?>;
    if (typeof jQuery === 'undefined') {
        document.write(unescape("%3Cscript src='<?= $url ?>/scripts/jquery-1.7.1.min.js' type='text/javascript'%3E%3C/script%3E"));
    }
</script>
<script type="text/javascript" src="<?= $url ?>/scripts/jBCrypt/bCrypt.js"></script>
<script type="text/javascript" src="<?= $url ?>/scripts/sha256.js"></script>
<script type="text/javascript" src="<?= $url ?>/scripts/scripts.js"></script>
