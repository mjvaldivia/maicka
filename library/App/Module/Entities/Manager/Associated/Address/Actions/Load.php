<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Module_Entities_Manager_Associated_Address_Actions_Load extends App_Module_Entities_Manager_Associated_Address_Actions_Abstract{
                
    /**
     * Carga los datos en el formulario
     * @param /Model/Entity/Address $address
     * @param string $code
     * @return array 
     */
    protected function _loadData($address, $code){
        
       $state_id = "";
       $country_id = "";
        
       $state =  $address->getState();
       if($state){
           $state_id = $state->getId();
       }
        
       $country = $address->getCountry();
       if($country){
           $country_id = $country->getId();
       }
       
       $status = $address->getType();
       if($status){
           $status_id = $status->getId();
       }
       
       $cargar = array(
            'entity_address_id_' . $code       => $address->getId(),
            "entity_address_street_" . $code   => $address->getStreet(),
            "entity_address_city_" . $code     => $address->getCity(),
            "entity_address_province_" . $code => $state_id,
            "entity_address_country_". $code   => $country_id,
            "entity_address_postal_" . $code   => $address->getPostal(),
            "entity_address_type_" . $code     => $status_id); 
       return $cargar;
    }
    
    /**
     * LLena el combo de provincias estado
     * @param /Model/Entity/Address $address
     * @param Zend_Form $form
     */
    protected function _specialPopulate($address, $form, $code){
       $state = $address->getState();
       if($state){
          $country = $state->getCountry(); 
          if($country){
              $province = "entity_address_province_" . $code;
              $form->{$province}->addMultiOptions($this->_getProvinceCombo($country->getId()));
          }
       }
    }
    
    
    /**
     * Devuelve el nombre del input como default
     * @param type $code
     * @return type 
     */
    protected function _checkedInputDefault($code){
        return $defaultInput = "entity_address_default_" . $code;
    }
    
    /**
     * Carga la entidad y sus direcciones
     */
    protected function _listRows(){
       if($this->_entity){
           $this->_rows = $this->_entity->listAddress();
       } 
    }
        
       
    
}
?>
