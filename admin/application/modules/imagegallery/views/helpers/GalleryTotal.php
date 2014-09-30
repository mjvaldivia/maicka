<?php

require_once(APPLICATION_PATH . "/modules/imagegallery/library/Action/Helpers/ListImages.php");

Class Zend_View_Helper_GalleryTotal extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     * Cantidado total de imagenes
     * @var int
     */
    protected $_total = 0;
    
    
    public function GalleryTotal($search){
        $this->_init();
        $this->_setTotal($search);
        
        if(50 < $this->_total){
            $this->_addHtml($this->view->partial("gallery-load-more.phtml", array("inicio" => 50)));
        }
        
        return $this->_getHtml();
    }
    
    /**
     * Devuelve el total de imagenes encontradas
     * @param string $search
     */
    protected function _setTotal($search){
        $list = New Helper_ListImages();
        $this->_total = $list->getTotal($search);
    }
}

