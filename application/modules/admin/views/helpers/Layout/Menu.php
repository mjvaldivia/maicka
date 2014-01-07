<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
Class Zend_View_Helper_Layout_Menu extends App_Utilitario_Helpers{  

    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     * Muestra el menu de navegacion 
     * de la izquierda
     * @return string
     */
    public function Layout_Menu(){
        $this->_init();
        if($this->_request->getControllerName()!="login"){
            return $this->view->partial("menu-izquierda.phtml", array());
        }
    }
}
?>