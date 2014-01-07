<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Module_Entities_Manager_Associated_Phone_Actions_Load extends App_Module_Entities_Manager_Associated_Phone_Actions_Abstract{
                
    /**
     * Carga los datos en el formulario
     * @param /Model/Entity/Phone $phone
     * @param string $code
     * @return array 
     */
    protected function _loadData($phone, $code){
       $cargar = array('entity_phone_id_' . $code => $phone->getId(),
                       "entity_phone_number_" . $code => $phone->getNumber(),
                       "entity_phone_type_" . $code   => $phone->getType()->getId());
       return $cargar;
    }
    
    /**
     * Devuelve el nombre del input como default
     * @param type $code
     * @return type 
     */
    protected function _checkedInputDefault($code){
        return $defaultInput = "entity_phone_default_" . $code;
    }
    
    /**
     * Carga la entidad y sus telefonos
     */
    protected function _listRows(){
       if($this->_entity){
           $this->_rows = $this->_entity->listPhones();
       } 
    }
    
}
?>
