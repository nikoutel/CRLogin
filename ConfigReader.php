<?php

class ConfigReader {

    public function __construct() {

    }

    public function readFile($file) {
        if (is_file($file)) {
           $arr = include $file;
           return $arr;
        } else {
            return FALSE;
        }
    }

}

?>
