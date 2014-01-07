<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Layout_Footer extends App_Utilitario_Helpers{  

    /**
     * Directorio actual
     * @var string
     */
    protected $_DIR = __DIR__;
    
    /**
     * Header
     * @return string
     */
    public function Layout_Footer(){
        $this->_init();
        if($this->_request->getControllerName()!="login"){
            return $this->view->partial("footer.phtml", array());
        }
    }
}
?>
