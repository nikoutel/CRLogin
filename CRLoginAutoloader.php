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

    $fileName = explode(DIRECTORY_SEPARATOR, $fileName);
    $basedir = array_shift($fileName);
    $fileName = implode(DIRECTORY_SEPARATOR, $fileName);
    
    if (true === file_exists($fileName)) {
        require_once($fileName);
        return true;
    } elseif (true === file_exists($basedir . DIRECTORY_SEPARATOR . $fileName)) {
        require_once($basedir . DIRECTORY_SEPARATOR . $fileName);
        return true;
    }
}

spl_autoload_register('CRLoginAutoloader');
?>
