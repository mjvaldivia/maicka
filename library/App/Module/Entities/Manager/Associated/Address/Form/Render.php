<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Associated_Address_Form_Render extends App_Module_Entities_Manager_Associated_Abstract{
    
    /**
     * Agrega el js para manejar combos enlazados country y state
     */
    public function init() {
        parent::init();
        
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $view->headScript()->appendFile('/js/common/country.js', 'text/javascript');
        
        

    }
    
    
    
    /**
     * Crea los elementos del formulario
     */
    protected function _createElements(){
        $this->addElement("DivStart",
                          'div_address',
                            array(
                                'attribs' => array("class"=>"div-address div-form-row" . $this->_deleteClass)
                            ))
              ->addElement("hidden",
                           "entity_address_code",
                           array(
                                'isArray' => true,
                                'value' => $this->_code,
                                'decorators' => $this->_hiddenDecorator)
                           )               
                
              ->addElement("hidden",
                           "entity_address_id_" . $this->_code,
                           array('decorators' => $this->_hiddenDecorator)
                           )
              ->addElement("text",
                           "entity_address_street_" . $this->_code,
                            array(
                                'label' => "Street*",
                                'required'   => true,
                                'decorators' => App_Utilitario_Forms::textDecorator(),
                                "class"      => "input-medium"
                            ))
              ->addElement("text",
                           "entity_address_city_" . $this->_code,
                            array(
                                'label' => "City*",
                                'required'     => true,
                                'decorators' => App_Utilitario_Forms::textDecorator(),
                                "class"      => "input-medium"
                            ))
              ->addElement("select",
                           "entity_address_country_" . $this->_code,
                            array(
                                'label' => "Country*",
                                'required'     => true,
                                'uncheckedValue' => null,
                                'decorators' => App_Utilitario_Forms::textMinDecorator(),
                                'attribs' => array("data-rel" => "chosen",
                                                   "rel" => "entity_address_province_" . $this->_code,
                                                   "class"      => "input-xlarge country"
                                                  )
                            ))
              ->addElement("select",
                           "entity_address_province_" . $this->_code,
                            array(
                                'label' => "Prov/State*",
                                'required'     => true,
                                'uncheckedValue' => null,
                                'decorators' => App_Utilitario_Forms::textDecorator(),
                                "data-rel" => "chosen"
                            ))
              ->addElement("text",
                           "entity_address_postal_" . $this->_code,
                            array(
                                'label' => "Postal/Zip Code*",
                                'required'     => true,
                                'decorators' => App_Utilitario_Forms::textDecorator(),
                                'attribs' => array("class" => "zip input-small", "nro" =>$this->_code)
                            ))
              ->addElement("select",
                           "entity_address_type_" . $this->_code,
                            array(
                                'label' => "Type*",
                                'required'     => true,
                                'decorators' => App_Utilitario_Forms::textDecorator(),
                                "data-rel" => "chosen"
                            ))
            
              ->addElement("Delete",
                          'entity_address_delete_' . $this->_code,
                           array(
                             'required'   => false,
                             'value'      => $this->_deleteValue,
                             'decorators' => App_Utilitario_Forms::textDecorator(),
                             'attribs'    => array("contenedor" => "address-content", "title" => "Delete Address")
							 ))
							 
            ->addElement("checkbox",
                          'entity_address_default_' . $this->_code,
                           array(
                             'required' => false,
                             'value' => $this->_code,
                             'attribs'   => array ("class" => "entity_checkbox_address" ,"title" => "Set Default Address"),
                             'decorators'   => $this->_checkboxDecorator))
              ->addElement("DivEnd",
                          'div_close_address');
        
        $this->_prepareForm();
    }
    
    /**
     * Genera los datos por defecto del formulario
     */
    protected function _prepareForm(){
        $countryRepository = App_Doctrine_Repository::repository("Country");
        $countryList = $countryRepository->listCountryOrderByName();
        
        $country      = "entity_address_country_" . $this->_code;
        $address_type = "entity_address_type_" . $this->_code;
    
        $type = New Dtz_Model_AddressType();
        
        $this -> {$address_type} 
              -> addMultiOptions(App_Utilitario_Form_Select::setFormat($type->getFieldTypes(), "Select")); 

        $this -> {$country}     
              -> addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($countryList, "getId", "getName")); 
    }
     
        
    
}
?>
