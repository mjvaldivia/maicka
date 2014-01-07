<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Module_Entities_Manager_Entity_Actions_Name_Load extends App_Module_Entities_Manager_Entity_Actions_Name_Abstract{
                
    
    /**
     * Carga datos del formulario
     * @return Zend_Form 
     */
    public function getForm(){
        $form = $this->_getForm();
        if($this->_modificar){
            $form->populate($this->_loadData($this->_entity));
        }
        return $form;
    }
    
   
    /**
     * Carga los datos en el formulario
     * @param /Model/Entity/Entities $entity
     * @return array 
     */
    protected function _loadData($entity){
        
       $cargar = array(
                    "entity_id" => $entity->getId(),
                    'name'      => $entity->getName(),
                    "company"   => $entity->getCompany()
                    ); 
       
      /* $image = $entity->getImage();
       if($image){
           $cargar['entity_image'] = $image->getId();
       }*/
       
       return $cargar;
    }

    
}
?>
