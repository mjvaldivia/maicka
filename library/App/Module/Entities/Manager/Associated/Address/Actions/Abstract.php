<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Abstract class App_Module_Entities_Manager_Associated_Address_Actions_Abstract extends App_Module_Entities_Manager_Associated{
    /**
     * Carga el formulario de telefonos
     * @return App_Module_Entities_Form_Phone_Form 
     */
    protected function _getForm(){
        $formulario = array(
                            'name'    => 'address',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'post',
                            'prefixPath' => array("path" => "App/Utilitario/Form",
                                                  "prefix" => "App_Utilitario_Form",
                                                  "type"   => \Zend_Form::ELEMENT));       
        $form = New App_Module_Entities_Manager_Associated_Address_Form_Render($formulario);
        return $form;
    }
    
    /**
     * Genera el arrelo para llenar el combo de provincias
     * @param type $countryId
     * @return type 
     */
    protected function _getProvinceCombo($countryId){
        $countryManager = App_Doctrine_Repository::repository("Country");
        $country = $countryManager->find($countryId);
        if($country){
            $states = $country->listStates();
            return  App_Utilitario_Form_Select::setFormatMethod($states, "getId", "getName", "Select");
        } else return array();
    }
    
}
?>
