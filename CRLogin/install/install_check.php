<?php
function configExists($configFile) {

    if (file_exists($configFile)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Checks if the configuration file is writable
 * 
 * @param string $configFile
 * @return boolean
 */
function configWritable($configFile) {

    if (is_writable($configFile)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Checks if a database extension is available
 * 
 * @param string $dbExtension
 * @return boolean
 */
function dbAvailable($dbExtension) {

    if (extension_loaded($dbExtension)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Checks if the version of PHP is sufficient
 * 
 * @param string $phpMinVersion
 * @return boolean
 */
function phpVersionCheck($phpMinVersion) {

    if (version_compare(PHP_VERSION, $phpMinVersion) >= 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>
