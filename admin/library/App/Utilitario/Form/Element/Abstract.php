<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
Abstract class App_Utilitario_Form_Element_Abstract extends Zend_Form_Element{
    
    /**
     * Nombre del PHTML que despliega el elemento
     * @var type 
     */
    protected $_script;
    
    /**
     * Vista actual
     * @var type 
     */
    protected $_view;
    
    /**
     * Clase para CSS del elemento
     * @var type 
     */
    protected $_class = "element";
    
    /**
     * Inicia el Elemento
     */
    public function init(){
            $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
            $view->addBasePath(APPLICATION_PATH . "/../library/App/Utilitario/Form/Element/View");
            
            
            parent::init();

            $this->setDecorators(array(
                array(),
            ));

            $this->addDecorator('ViewScript', array(
                'viewScript' => $this->_getScript(),
                'class'      => $this->_getClass()
            ));
            
            $this->_view = $view;
    }
    
    
    /**
     * Setea el nombre de la clase
     * @param type $class 
     */
    protected function _setClass($class){
        $this->_class = $class;
    }
    
    /**
     * Devuelve el nombre de la clase
     * @return type 
     */
    protected function _getClass(){
        return $this->_class;
    }
    
    /**
     * Setea el nombre del script
     * @param type $script 
     */
    protected function _setScript($script){
        $this->_script = $script;
    }
    
    /**
     * Devuelve el nombre del script
     * @return type 
     */
    protected function _getScript(){
        return $this->_script;
    }
}
?>
