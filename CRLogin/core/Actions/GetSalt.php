<?php

namespace CRLogin\core\Actions;
use CRLogin\core\Crypt;

class GetSalt implements Actions {

    private $_container;

    public function __construct($container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguageFile();
    }

    public function executeAction() {
        $crypt = new Crypt($this->_container);
        $newSalt = $crypt->getNewSalt();
        if ($newSalt === FALSE) {
            return array(
                'error' => TRUE,
                'errorMsg' => ''
            );
        } else {
            $_SESSION['newsalt'] = $newSalt;
            return array('newsalt' => $newSalt);
        }
    }

}

?>
