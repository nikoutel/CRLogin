<?php

class Utils {

    public function isAssociative($array) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

    public function startsWith($haystack, $needle) {
        return !strncasecmp($haystack, $needle, strlen($needle));
    }

}

?>
