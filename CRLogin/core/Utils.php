<?php

class Utils {

    public function isAssociative($array) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

    public function startsWith($haystack, $needle) {
        return !strncasecmp($haystack, $needle, strlen($needle));
    }

    public function in_array_recursive($needle, $haystack) {
        foreach ($haystack as $item) {
            if (($item == $needle) || (is_array($item) && $this->in_array_recursive($needle, $item))) {
                return true;
            }
        }
        return false;
    }

}

?>
