<?php

Class Vendor_View_Helper_MessageError extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     * Muestra el cuadro de mensaje de error
     * @param string $titulo
     * @param string $mensaje
     * @return string html
     */
    public function MessageError($titulo, $mensaje){
        $this->_init();
        if($mensaje!=""){
            return $this->view->partial("message-error.phtml", array("titulo" => $titulo, "mensaje" => $mensaje));
        }
    }
}

