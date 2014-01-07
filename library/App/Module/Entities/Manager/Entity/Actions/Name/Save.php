<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Entity_Actions_Name_Save extends App_Module_Entities_Manager_Entity_Actions_Name_Abstract{
    
    protected $_form;
    
    protected $_entityManager;
    
    public function __construct() {
        parent::__construct();
        $this->_entityManager = App_Doctrine_Repository::entityManager();
    }
    
    /**
     * Ve si es valido el formulario
     * @return boolean
     */
    public function isValid(){
        $this->_form = $this->_getForm();
        if($this->_form->isValid($this->_request->getParams())){
            return true;
        } else{
            $this->_form->processErrors();
            return false;
        }
    }
    
    /**
     * Recupera el formulario
     * @return Zend_form
     */
    public function getForm(){
        return $this->_form;
    }
    
    /**
     * Guarda el formulario
     */
    public function save(){
        if($this->_modificar){
            $this->_entity->setName($this->_request->getParam("name"));
            $this->_entity->setCompany($this->_request->getParam("company"));
            //$this->_entity->setLastName($this->_request->getParam("last_name"));
            
            
            
            //$this->_entity->setImage($this->_getImage());
            
            $this->_entityManager->persist($this->_entity);
        } else {
            $entity = New \Model\Entity\Entities();
            $entity->setName($this->_request->getParam("name"));
            $entity->setCompany($this->_request->getParam("company"));
            $this->_entityManager->persist($entity);
        }
        
    }
    
    /**
     * Recupera la imagen
     * @return type 
     */
   /* protected function _getImage(){
        $image = App_Doctrine_Action_Find::primary("Photos", $this->_form->getValue("entity_image"));
        if($image){
            $image->setProcessed(true);
            $this->_entityManager->persist($image);
            return $image;
        }
    }*/
}
?>
