<?php
/*
 * Prevents the direct access of this file 
 */
if (count(get_included_files()) == 1) {
    header("HTTP/1.1 404 Not Found", 404);
    die();
}
/*
 * Requirements
 */
$dir = realpath(dirname(__FILE__) . '/../config'); // consider putting this outside your document root for security
$basedir = basename(realpath(dirname(__FILE__) . '/../config'));
$file = 'install_config10.php';
$requirements = array(
    'phpMinVersion' => '5.3.0',
    'configFileBase' => $basedir . DIRECTORY_SEPARATOR . $file,
    'configFile' => $dir . DIRECTORY_SEPARATOR . $file, 
    'dbExtension' => array(
        'mysqlExtension' => 'mysql',
        'sqliteExtension' => 'sqlite3'
    )
);
?>
