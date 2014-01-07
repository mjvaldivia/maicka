<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Login_Mensaje extends App_Utilitario_Helpers{  

    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     * Caja de mensaje
     * @return string
     */
    public function Login_Mensaje($mensaje, $correcto){
        $this->_init();
        
        if($correcto){
            $class = "alert-info";
        } else {
            $class = "alert-error";
        }
        
        return $this->view->partial("div-mensaje.phtml", array("class" => $class, "mensaje" => $mensaje));
    }
}
?>
