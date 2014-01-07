<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Module_Entities_Manager_Associated_Abstract extends App_Form_Decorator_Abstract{

    protected $_code;
    
    protected $_deleteValue = 0;
    
    protected $_deleteClass = "";
        
    public function init() {
        parent::init();
        $this->setDecorators(array('FormElements'));
    }
    
    /**
     * Setea la fila como eliminada y la oculta
     * @param boolean $value 
     */
    public function setDelete($value){
        if($value){
            $this->_deleteValue = $value;
            $this->_deleteClass = " div-hide";
        }
    }
    
    /**
     * Crea una nueva fila de elementos
     */
    public function createNewElements(){
        $this->_generateCode();
        $this->_createElements();
    }
    
    /**
     * Crea una fila para modificar
     */
    public function createExistingElement(){
        $this->_createElements();        
    }
    
    /**
     * Setea el codigo de la fila
     * @param type $code 
     */
    public function setCode($code){
        $this->_code = $code;
    }
    
    /**
     * Recupera el codigo de la fila
     * @return type 
     */
    public function getCode(){
        return $this->_code;
    }
    
    /**
     * Genera el codigo de la fila
     */
    protected function _generateCode(){
        if(Zend_Registry::isRegistered("entity_address_code")){
           $codes = Zend_Registry::get("entity_address_code");
        } else $codes = array();
        
        $code = rand(10000, 1000000);
        while(in_array($code, $codes)){
            $code = rand(10000, 100000);    
        }
        
        $codes[] = $code;
        
        Zend_Registry::set("entity_address_code", $codes);
        
        $this->_code = $code;
    }
}
?>
