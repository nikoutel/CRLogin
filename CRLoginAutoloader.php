<?php

function CRLoginAutoloader($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
//    echo realpath('.');
//    echo ' : ';
//    echo $fileName;
//    echo '<br />';
//    \Debugr::edbgLog($fileName, '$fileName');

    req($fileName);
}

function req($fileName) {
    if (true === file_exists($fileName)) {
        require_once($fileName);
        return true;
    } else {
        $fileName = explode(DIRECTORY_SEPARATOR, $fileName);
        array_shift($fileName);
        if ($fileName !== NULL) {
            $fileName = implode(DIRECTORY_SEPARATOR, $fileName);
            req($fileName);
        }
    }
}

spl_autoload_register('CRLoginAutoloader');
?>
