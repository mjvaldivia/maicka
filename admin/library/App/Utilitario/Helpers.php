<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Abstract class App_Utilitario_Helpers extends Zend_View_Helper_Abstract{
    
     /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     * Salida html del helper
     * @var html 
     */
    protected $_html = "";
    
    /**
     *
     * @var \Zend_Controller_Request_Abstract 
     */
    protected $_request;
   
    /**
     * Init
     */
    public function _init() {
        $this->_html = "";
        $this->_request = Zend_Controller_Front::getInstance()->getRequest();
        $this->_addView();
    }
    
    /**
     * Añade una linea a la salida
     * @param type $html 
     */
    protected function _addHtml($html){
        $this->_html .= $html;
    }
    
    /**
     * Devuelve el html generado
     * @return type 
     */
    protected function _getHtml(){
        return $this->_html;
    }
    
     /**
     * Añade la carpeta con las vistas
     */
    protected function _addView(){
        $this->view->addBasePath($this->_DIR . "/views");
    }
}
?>
