<?php

class Crypt {

    private $_salt;
    private $_random;
    private $_container;

    public function __construct($container) {
        $this->_container = $container;
    }

    public function encrypt($string, $salt) {

        $hash = crypt($string, $salt);

        if (strlen($hash) > 13)
            return $hash;
        else
            return false;
    }

    private function _generateSalt() {
        $configuration = $this->_container->getConfiguration('general');
        $costParameter = $configuration['cryptCostParameter'];
        if (version_compare(PHP_VERSION, '5.3.7', '>')) {
            $prefix = '$2y$';
        } else {
            $prefix = '$2a$';
        }
        $innerSalt = $this->getRandom($encode = 'salt');
        if (!$innerSalt) {
            $this->_salt = $prefix . $costParameter . '$' . $innerSalt . '$';
        }
        else
            $this->_salt = FALSE;
    }

    public function getNewSalt() {
        if (empty($this->_salt)) {
            $this->_generateSalt();
        }
        return $this->_salt;
    }

    public function getRandom($encode = FALSE) {

        if ($encode == 'challenge') {
            $size = 32;
        } else {
            $size = 16;
        }

        $this->_random = '';
        if (function_exists('mcrypt_create_iv')) {
            if (defined('MCRYPT_DEV_URANDOM')) {
                $source = MCRYPT_DEV_URANDOM;
            } else {
                $source = MCRYPT_RAND; //
            }

            $this->_random = mcrypt_create_iv($size, $source);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {

            $this->_random = openssl_random_pseudo_bytes($size);
        } elseif (is_readable('/dev/urandom') && ($fp = @fopen('/dev/urandom', 'rb')) !== FALSE) {

            $this->_random .= @fread($fp, $size);
            @fclose($fp);
        } else {

            $this->_random = sha1(uniqid(mt_rand()));
        }
        if (!$encode)
            return $this->_random;
        else
            return $this->_encode($this->_random, $encode);
    }

    private function _encode($random, $encode) {

        if ($encode == 'salt') {
            return substr(strtr(base64_encode($random), '+', '.'), 0, 22);
        } elseif ($encode == 'challenge') {
            return substr(base64_encode($random), 0, 40);
        } else {
            return FALSE;
        }
    }

}

?>
