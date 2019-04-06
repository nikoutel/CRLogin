<?php

//@todo test CRL_BASE_DIR with call; if not ajax


$baseURL = dirname("//{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}");
define('CRL_BASE_URL', $baseURL);

if (!defined('CRL_BASE_DIR')) define('CRL_BASE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/' . dirname(dirname($_SERVER['SCRIPT_NAME'])));
if (!defined('CRL_APP_DIR')) define('CRL_APP_DIR', basename(dirname($_SERVER['SCRIPT_NAME'])));
