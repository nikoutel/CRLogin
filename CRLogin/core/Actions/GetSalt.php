<?php

namespace CRLogin\core\Actions;

class Actions_GetSalt implements Actions_Actions {

    private $_container;

    public function __construct($container) {
        $this->_container = $container;
        $this->_l = $this->_container->getLanguage();
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
