<?php


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


    if ($error) {
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $errormsg = 'All fields are required <br />';
            $_SESSION['errormsg'] = $errormsg;
            header("Location: $installScriptName");
            die();
        }
    }

    /*
     * Checks if a connection to the database with the given information is possible 
     * Provides the appropriate response
     */
    $check = checkMySQLConnection($host, $port, $rootUser, $rootPass);
    if ($check === FALSE) {
        $error = 'There was an error connecting to the database: ' . mysql_error();

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        $connection = $check;
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
        $error = 'There was an error creating the database: ' . mysql_error();

        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $_SESSION['errormsg'] = $error;
            header("Location: $installScriptName");
        }
        else
            echo $error;
        die();
    } else {
        $db_selected = mysql_select_db($databaseName, $connection);
        if (!$db_selected) {
            die(mysql_error());
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

        $error = 'There was an error creating the user: ' . mysql_error();

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
            $selectNdb = mysql_select_db($databaseName, $checkN);
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

        $error = 'There was an error creating the required tables: ' . mysql_error();

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

        $error = 'There was an error creating initial user: ' . mysql_error();

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
    $wconf = writeConfig($_SESSION['configFile'], $host, $port, $user, $userPass, $databaseName);
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
