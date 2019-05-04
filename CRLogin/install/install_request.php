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
require dirname($_SERVER['DOCUMENT_ROOT']).'/tools/Debugr/src/Debugr.php';
use Nikoutel\Debugr\Debugr;
/*
 * Initialization
 */
ini_set('display_errors', 0);
if (!isset($_POST['inform'])) {
    die();
}
require 'install_lib.php';
require 'install_requirements.php';
session_start();
if (isset($_SESSION['installScriptName'])) {
    $installScriptName = $_SESSION['installScriptName'];
} else {
    die();
}

/*
 * Controls the creation of the configuration file
 */
if ((isset($_GET['action'])) && ($_GET['action'] == "create")) {
    $filename = $_POST['filename'];
    $create = createConfigFile($filename);
    $_SESSION['errormsgconf'] = '';
    if ($create === FALSE) {
        $error = 'Could not create  <i>' . $filename;
        $error .= '</i><br />Create it manually ';

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsgconf'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header("Location: $installScriptName");
        } else {
            echo 'ok';
        }
    }
}

/*
 * Controls the input from the database configuration form
 */
if ((isset($_GET['action'])) && ($_GET['action'] == "form")) {

    $error = FALSE;
    $rootUser = $_POST['rootuser'];
    $error = ifEmpty($rootUser) and $error;

    $rootPass = $_POST['rootpass'];

    $host = $_POST['host'];
    $error = ifEmpty($host) and $error;

    $port = $_POST['port'];
    $error = ifEmpty($port) and $error;

    $databaseName = $_POST['database_name'];
    $error = ifEmpty($databaseName) and $error;

    $user = $_POST['user'];
    $error = ifEmpty($user) and $error;

    $userPass = $_POST['userpass'];

    $loginform = $_POST['loginform'];
    $error = ifEmpty($loginform) and $error;

    $successredirect = $_POST['successredirect'];
    $error = ifEmpty($successredirect) and $error;

    $parseURLLoginForm = parse_url($loginform);
    $parseURLSuccesRedirect = parse_url($successredirect);

    $baseURL = '//' . $parseURLLoginForm['host'];
    if (!empty($parseURLLoginForm['port'])) {
        $baseURL .= ':' . $parseURLLoginForm['port'];
    }

    $loginFormReqURI = $parseURLLoginForm['path'];
    if (!empty($parseURLLoginForm['query'])) {
        $loginFormReqURI .= '?' . $parseURLLoginForm['query'];
    }
    if (!empty($parseURLLoginForm['fragment'])) {
        $loginFormReqURI .= '#' . $parseURLLoginForm['fragment'];
    }

    $loginSuccessDefURI = $parseURLSuccesRedirect['path'];
    if (!empty($parseURLSuccesRedirect['query'])) {
        $loginSuccessDefURI .= '?' . $parseURLSuccesRedirect['query'];
    }
    if (!empty($parseURLSuccesRedirect['fragment'])) {
        $loginSuccessDefURI .= '#' . $parseURLSuccesRedirect['fragment'];
    }

    $appURLPath = dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))) ;
    if ($appURLPath != '/') {
        $appURLPath .= '/';
    }

$_SESSION['loginFormReqURI'] = $loginFormReqURI;
    if ($error) {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $errormsg = 'All fields are required <br />';
            $_SESSION['errormsg'] = $errormsg;
            header("Location: $installScriptName");
            die();
        }
    }
    echo "<div id='bla'>";


echo '</div>';
    /*
     * Checks if a connection to the database with the given information is possible 
     * Provides the appropriate response
     */
    $connection = checkMySQLConnection($host, $port, $rootUser, $rootPass);
    if ($connection === FALSE) {
        $error = 'There was an error connecting to the database: ' . mysqli_connect_error();

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        $msg = 'Database connection has been established <br />';
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['msg'] = $msg;
        }
        else
            echo $msg;
    }

    /*
     * Creates the database
     * Provides the appropriate response
     */
    $db = createDb($connection, $databaseName);
    if ($db === FALSE) {
        $error = 'There was an error creating the database: ' . mysqli_error($connection);

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        $db_selected = mysqli_select_db($connection, $databaseName);
        if (!$db_selected) {
            die(mysqli_error($connection));
        }
        $msg = 'The database <i>"' . $databaseName . '"</i> has been created <br />';
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['msg'] = $msg;
        }
        else
            echo $msg;
    }


    /*
     * Creates the database user
     * Provides the appropriate response
     */
    $cuser = createUser($connection, $databaseName, $user, $userPass, '%');
    if ($cuser === FALSE) {

        $error = 'There was an error creating the user: ' . mysqli_error($connection);

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        /*
         * Check if the new user has really the permissions needed
         */
        $checkN = checkMySQLConnection($host, $port, $user, $userPass);
        if ($checkN !== FALSE) {
            $selectNdb = mysqli_select_db($checkN, $databaseName);
            if ($selectNdb) {
                $msg = 'The user <i>"' . $user . '"</i> has been created <br />';
                if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                    $_SESSION['msg'] .= $msg;
                }
                else
                    echo $msg;
            }
        }
        if ($checkN === FALSE || $selectNdb === FALSE) {
            /*
             * There seems to be a problem.
             * This could be caused by the 'anonymous' user MySQL creates
             * If the DB is on 'localhost' create a user: user@'localhost' 
             * instead of user@'%'. 
             */
            if ($host == 'localhost' || $host = '127.0.0.1') {
                $cuser = createUser($connection, $databaseName, $user, $userPass, 'localhost');


                if ($cuser) {
                    $msg = 'The user <i>"' . $user . '"</i> has been created <br />';
                    if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                        $_SESSION['msg'] .= $msg;
                    }
                    else
                        echo $msg;
                }
                // @todo: more error control
            } else {
                $error = 'error: an unknown error has occurred';
                $error .= ' Try manual installation';

                if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                    $_SESSION['errormsg'] = $error;
                    header("Location: $installScriptName");
                }
                else
                    echo $error;
                die();
            }
        }
    }

    /*
     * Creates the tables needed
     * Provides the appropriate response
     */
    $tables = createTables($connection);
    if ($tables === FALSE) {

        $error = 'There was an error creating the required tables: ' . mysqli_error($connection);

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        $msg = 'The required tables have been created<br />';
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['msg'] .= $msg;
        }
        else
            echo $msg;
    }

    /**
     * Insert the initial note
     * Provides the appropriate response
     */
    $iuser = insertUser($connection);
    if ($iuser === FALSE) {

        $error = 'There was an error creating initial user: ' . mysqli_error($connection);

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } elseif ($iuser === TRUE) {
        $msg = 'Initial user has been inserted<br />';
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['msg'] .= $msg;
        }
        else
            echo $msg;
    }

    /*
     * Writes all gathered database information to the configuration file
     * Provides the appropriate response
     */
    $pass = mysqli_real_escape_string($connection, $userPass);
    $wconf = writeConfig($_SESSION['configFile'], $host, $port, $user, $userPass, $databaseName, $baseURL, $appURLPath, $loginFormReqURI, $loginSuccessDefURI);
    if ($wconf === FALSE) {

        $error = 'There was an error creating the configuration file, check your permissions';

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        $msg = 'Configuration file has been written <br />';
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['msg'] .= $msg;
        }
        else
            echo $msg;
    }
    $_SESSION['done'] = TRUE;
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {

        header("Location: $installScriptName");
        die();
    }
}
?>
