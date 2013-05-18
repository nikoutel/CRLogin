<?php

class Utils {

    public function isAssociative($array) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

}

?>
