<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Module_Entities_Manager_Associated_Email_Actions_Load extends App_Module_Entities_Manager_Associated_Email_Actions_Abstract{
                
    /**
     * Carga los datos en el formulario
     * @param /Model/Entity/Email $email
     * @param string $code
     * @return array 
     */
    protected function _loadData($email, $code){
       $cargar = array(
                    'entity_email_id_' . $code => $email->getId(),
                    "entity_email_address_" . $code => $email->getEmail(),
                    "entity_email_type_" . $code   => $email->getType()->getId()
                    ); 
       return $cargar;
    }
    
    /**
     * Devuelve el nombre del input como default
     * @param type $code
     * @return type 
     */
    protected function _checkedInputDefault($code){
        return $defaultInput = "entity_email_default_" . $code;
    }
    
    /**
     * Carga la entidad y sus telefonos
     */
    protected function _listRows(){
       if($this->_entity){
           $this->_rows = $this->_entity->listEmails();
       } 
    }
    
}
?>
