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

    public function generateSalt() {
        $configuration = $this->_container->getConfiguration('general');
        $costParameter = $configuration['cryptCostParameter'];
        if (version_compare(PHP_VERSION, '5.3.7', '>')) {
            $prefix = '$2y$';
        } else {
            $prefix = '$2a$';
        }
        $ff = $this->encode($this->getRandom());
        $this->_salt = $prefix . $costParameter . '$' . $ff . '$';
    }

    public function getNewSalt() {
        if (empty($this->_salt)) {
            $this->generateSalt();
        }
        return $this->_salt;
    }

    public function getRandom() {
        $count = 16;
        $bytes = '';
        if (function_exists('mcrypt_create_iv')) {

            $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
            $ransom = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
            
        } elseif (function_exists('openssl_random_pseudo_bytes')) {

            $bytes = openssl_random_pseudo_bytes($count);
        } elseif (is_readable('/dev/urandom') && ($fp = @fopen('/dev/urandom', 'rb')) !== FALSE) {

            $bytes .= @fread($fp, $count);
            @fclose($fp);
        } else {
            $bytes = sha1(uniqid(mt_rand()));
        }
        return $this->_random;
    }

    public function encode($random) {

        return substr(strtr(base64_encode($random), '+', '.'), 0, 22);
    }

}
?>
