<?php

/**
 *
 * This is a TEMPORARY SCRIPT. Its just a quick install solution.
 * A new, more dynamic and configurable application is on its way.
 * 
 * 
 * @package CRLogin
 * @subpackage install
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
/*
 * Prevents the direct access of this file 
 */
if (count(get_included_files()) == 1) {
    header("HTTP/1.1 404 Not Found", 404);
    die();
}

ini_set('display_errors', 0);

/**
 * Creates thr configuration file
 * 
 * @param string $filename
 * @return boolean
 */
function createConfigFile($filename) {
    $create = @touch($filename);

    if (!$create) {

        return FALSE;
    }
    return $create;
}

/**
 * Checks for a MySQL Connection
 * 
 * @param string $host
 * @param string $port
 * @param string $rootUser
 * @param string $rootPass
 * @return boolean
 */
function checkMySQLConnection($host, $port, $rootUser, $rootPass) {
    $connect = mysqli_connect($host . ':' . $port, $rootUser, $rootPass);
    if (!$connect) {

        return FALSE;
    }
    return $connect;
}

/**
 * Creates a database
 * 
 * @param resource $connect
 * @param string $db
 * @return boolean
 */
function createDb($connect, $db) {
    $db_esc = mysqli_real_escape_string($connect, $db);
    $query = "CREATE DATABASE IF NOT EXISTS " . $db_esc;
    $result = mysqli_query($connect, $query);
    if ($result) {
        return TRUE;
    } else {

        return FALSE;
    }
}

/**
 * Creates the user
 * 
 * @param resource $connect
 * @param string $db
 * @param string $user
 * @param string $dbpass
 * @param string $atHost
 * @return boolean
 */
function createUser($connect, $db, $user, $dbpass, $atHost) {


    $db_esc = mysqli_real_escape_string($connect, $db);
    $user_esc = mysqli_real_escape_string($connect, $user);
    $dbpass_esc = mysqli_real_escape_string($connect, $dbpass);
    $query = "GRANT ALL ON " . $db_esc . ".* to  " . $user_esc . "@'" . $atHost . "' identified by '" . $dbpass_esc . "'";
    $result = mysqli_query($connect, $query);
    if ($result) {
        return TRUE;
    } else {

        return FALSE;
    }
}

/**
 * Creates the tables 
 * 
 * @param resource $connect
 * @return boolean
 */
function createTables($connect) {

    $query = "CREATE TABLE IF NOT EXISTS crl_user (
                userid int(11) unsigned NOT NULL auto_increment,
                username varchar(64) NOT NULL default '',
                spass varchar(64) NOT NULL default '',
                usersalt varchar(64)	NOT NULL default '',
                PRIMARY KEY  (userid)
                ) ENGINE=MyISAM";

    $result = mysqli_query($connect, $query);

    $query2 = "CREATE TABLE IF NOT EXISTS crl_challenge  (
	  	 challenge varchar(64) NOT NULL default '',
 		 sessionid varchar(64) NOT NULL default '',
  		 timestamp int(11) NOT NULL default '0'
		 ) ENGINE=MyISAM";

    $result2 = mysqli_query($connect, $query2);

    $query3 = "CREATE TABLE IF NOT EXISTS crl_sessions (
                id varchar(32) NOT NULL default '',
                access int(10) unsigned NOT NULL,
                data text,
                PRIMARY KEY (id)
                ) ENGINE=MyISAM";

    $result3 = mysqli_query($connect, $query3);

    if ($result && $result2 && $result3) {
        return TRUE;
    } else {

        return FALSE;
    }
}

/**
 * Inserts the initial user into the database 
 * 
 * @param resource $connect
 * @return boolean
 */
function insertUser($connect) {
    $username = 'user';
    $spass = '$2y$10$HLmNt5jH6ElynYSSe.fZS.Q/.dq4Jy6K/39kvoyg7rsnMEtYlIYH2';
    $usersalt = '$2y$10$HLmNt5jH6ElynYSSe.fZSA$';

    $result = mysqli_query($connect, "SELECT userid FROM crl_user WHERE username = '" . $username . "'");

    $count = mysqli_num_rows($result);

    if ($count == 0) {


        $query = "INSERT INTO crl_user (username,spass,usersalt) VALUES('$username','$spass','$usersalt')";

        $result = mysqli_query($connect, $query);

        if ($result) {
            return TRUE;
        } else {

            return FALSE;
        }
    } else
        return -1;
}

/**
 * Writes all gathered database information to the configuration file
 * 
 * @param string $file
 * @param string $host
 * @param string $port
 * @param string $user
 * @param string $pass
 * @param string $db
 * @return int|boolean Returns false on error
 */
function writeConfig($file, $host, $port, $user, $pass, $db, $baseURL, $appURLPath, $loginFormReqURI, $loginSuccessDefURI) {


    $string = "<?php\n";

    $string .='use CRLogin\DataAccess\DatabaseDrivers;' . "\n";
    $string .= "\n";
    $string .= '$db_config = array(' . "\n";
    $string .= "'db' => array(\n";
    $string .= "'databaseDriver' => DatabaseDrivers::MySQL,\n";
    $string .= "'host' => '$host',\n";
    $string .= "'dbName' => '$db',\n";
    $string .= " 'username' => '$user',\n";
    $string .= " 'password' => '$pass',\n";
    $string .= " 'port' => '$port',\n";
    $string .= " 'dbOptions' => array(";
    $string .= " )\n";
    $string .= " ),\n";
    $string .= " 'general' => array(\n";
    $string .= " 'language' => '" . $_SESSION['lang'] . "',\n";
    $string .= " 'installUniqueId' => '" . getRandom() . "',\n";
    $string .= " 'baseURL' => '" . $baseURL . "',\n";
    $string .= " 'appURLPath' => '" . $appURLPath. "',\n";
    $string .= " 'loginFormReqURI' => '" . $loginFormReqURI . "',\n";
    $string .= " 'loginSuccessDefURI' => '" . $loginSuccessDefURI . "'\n";
    $string .= ")\n";
    $string .= " );\n";
    $string .= 'return $db_config;' . "\n";

    $string .= "?>\n";




    return @file_put_contents($file, $string);
}

/**
 * Checks if a variable is empty or whitespace only
 * 
 * @param mixed $var
 * @return boolean
 */
function ifEmpty($var) {
    $var_trimed = rtrim($var);
    if (empty($var_trimed)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function getRandom() {

        $size = 16;


    $random = '';
    if (function_exists('mcrypt_create_iv')) {
        if (defined('MCRYPT_DEV_URANDOM')) {
            $source = MCRYPT_DEV_URANDOM;
        } else {
            $source = MCRYPT_RAND;
        }

        $random = mcrypt_create_iv($size, $source);
    } elseif (function_exists('openssl_random_pseudo_bytes')) {

        $random = openssl_random_pseudo_bytes($size);
    } elseif (is_readable('/dev/urandom') && ($fp = @fopen('/dev/urandom', 'rb')) !== FALSE) {

        $random .= @fread($fp, $size);
        @fclose($fp);
    } else {

        $random = sha1(uniqid(mt_rand()));
    }
    
    return substr(strtr(base64_encode($random), '+', '.'), 0, 22);

}

?>
