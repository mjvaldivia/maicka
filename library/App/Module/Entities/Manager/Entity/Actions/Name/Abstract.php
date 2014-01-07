<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Abstract class App_Module_Entities_Manager_Entity_Actions_Name_Abstract {
    
     /**
     * Entity manager para entities
     * @var type 
     */
    protected $_entitiesEntity;
    
    /**
     * Entidad actual
     * @var /Model/Entity/Entities
     */
    protected $_entity;
    
    /**
     * Si es true, se debe modificar la entidad
     * @var boolean 
     */
    protected $_modificar = false;
    
    protected $_request;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_request       = Zend_Controller_Front::getInstance()->getRequest();
        $this->_entitiesEntity = App_Doctrine_Repository::repository("Entities");
    }
    
      /**
     * Carga el formulario 
     * @return App_Module_Entities_Manager_Entity_Form_Name 
     */
    protected function _getForm(){
        $formulario = array(
                            'name'    => 'name',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'post',
                            'prefixPath' => array("path" => "App/Utilitario/Form",
                                                  "prefix" => "App_Utilitario_Form",
                                                  "type"   => \Zend_Form::ELEMENT));       
        $form = New App_Module_Entities_Manager_Entity_Form_Name($formulario);
        return $form;
    }
    
     /**
     *  Carga la entidad y los telefonos asociados
     * @param integer $entityId identificador de la entidad
     */
    public function setEntity($entity){
        
         if($entity instanceof Model\Entity\Entities){
            $this->_modificar = true;               
            $this->_entity = $entity;
        } else throw New Exception("The entity don't exist in " . __METHOD__);
    }
    
    
}
?>
