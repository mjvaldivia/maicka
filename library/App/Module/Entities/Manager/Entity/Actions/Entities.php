<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Entity_Actions_Entities{
    
    /**
     * Entity manager para entities
     * @var type 
     */
    protected $_entitiesEntity;
    
    /**
     *
     * @var /Model/Entity/Entities 
     */
    protected $_entity;
    
    protected $_modify = false;
    
    /**
     * Inicia la clase
     * Setea el entity como nuevo
     */
    public function __construct() {
        $this->_entitiesEntity = App_Doctrine_Repository::repository("Entities");
    }
    
    /**
     * Setea la entidad mediante el id
     * @param type $entityId 
     */
    public function setEntity($entityId){
        $entity = $this->_entitiesEntity->find($entityId);
        if($entity){
               $this->_entity = $entity;              
        } 
    }
    
    /**
     * Recupera la entidad
     * @return /Model/Entity/Entities
     */
    public function getEntity(){
        if($this->_entity){
           $this->_modify = true;
           return $this->_entity;
        } else {
           return  new \Model\Entity\Entities;
        }
    }
    
    /**
     * Retorna si se esta modificando la entidad
     * @return boolean 
     */
    public function isModify(){
        return $this->_modify;
    }
}

?>
