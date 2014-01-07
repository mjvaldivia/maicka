<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

abstract class App_Module_Entities_Manager_Associated{
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
     * Lista de registros asociados a la entidad
     * @var /Model/Entity/Phone 
     */
    protected $_rows;
    
    /**
     * Si es true, se debe modificar la entidad
     * @var boolean 
     */
    protected $_modificar = false;
    
    /**
     * Si es true, significa que se esta agregando una linea al formulario
     * @var boolean 
     */
    protected $_isAddLine = false;
    
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_entitiesEntity = App_Doctrine_Repository::repository("Entities");
    }
    
    
    /**
     *  Carga la entidad y los telefonos asociados
     * @param integer $entityId identificador de la entidad
     */
    public function setEntity($entity){
        if($entity instanceof Model\Entity\Entities){
            $this->_modificar = true;               
            $this->_entity = $entity;
            $this->_listRows();
        } else throw New Exception("The entity don't exist in " . __METHOD__);
    }
    
    /**
     * Le dice a la clase que solo se esta agregando una linea
     */
    public function isAddline(){
        $this->_isAddLine = true;
    }
    
    /**
     * Devuelve el formulario
     * @return html $phoneform 
     */
    public function getForm(){
        
        $returnForm = "";
        $existe = false;
        
        if($this->_modificar){
            if($this->_rows){
                foreach($this->_rows as $row){
                    $form = $this->_getForm();
                    $form->createNewElements();
                    $code = $form->getCode();
                    $this->_specialPopulate($row, $form, $code);
                    $form->populate($this->_loadData($row, $code));

                    if($row->getDefault()==1){
                        $form->{$this->_checkedInputDefault($code)}->setAttrib("checked", "checked");
                    }

                    $returnForm .= $form;
                    $existe = true;
                }
            }
        }
        
        if(!$existe){
            $form = $this->_getForm();
            $form->createNewElements();
            if(!$this->_isAddLine){
                $code = $form->getCode();
                $form->{$this->_checkedInputDefault($code)}->setAttrib("checked", "checked");
            }
            $returnForm = $form;
        }
        
        return $returnForm;
    }
    
    /**
     * Funcion para sobreescribir, carga datos especiales al formulario
     * Como llenar combos con valores
     * @param type $form 
     */
    protected function _specialPopulate($row, $form, $code){
        
    }
    
    /**
     * Carga los registros asociados
     * Esta funcion debe ser sobreescrita
     */
    protected function _listRows(){
        $this->_rows = array();
      /* if($this->_entity){
           $this->_rows = $entity->listPhones();
       } 
      */
    }
    
    /**
     * Carga los datos hacia el formulario
     * Esta funcion debe ser sobreescrita
     */
    protected function _loadData($row, $code){
        
    }
    
    /**
     *Devuelve el nombre del check para el row por defecto
     * Esta funcion debe ser sobreescrita
     * @param type $code 
     */
    protected function _checkedInputDefault($code){
        
    }
    
    /**
     * Carga el formulario
     * Esta funcion debe ser sobreescrita con el formulario
     */
    protected function _getForm(){
        
    }   
    
    

}
?>
