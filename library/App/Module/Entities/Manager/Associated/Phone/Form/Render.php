<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Associated_Phone_Form_Render extends App_Module_Entities_Manager_Associated_Abstract{
    public function _createElements() {

        $this->addElement("DivStart",
                          'div_address',
                            array(
                                    'attribs'      => array("class"=>"div-phone div-form-row" . $this->_deleteClass)
                            ))
              ->addElement("hidden",
                           "entity_phone_code",
                           array(
                                'isArray' => true,
                                'value' => $this->_code,
                                'decorators' => $this->_hiddenDecorator)
                           )
              ->addElement("hidden",
                           "entity_phone_id_" . $this->_code,
                           array('decorators' => $this->_hiddenDecorator)
                           )
              ->addElement("text",
                           "entity_phone_number_" . $this->_code,
                            array(
                                'label' => "Phone*",
                                'required'     => true,
                                'decorators' => $this->_textDecorator
                                ))
 
             ->addElement("select",
                          "entity_phone_type_" . $this->_code,
                            array(
                                'label' => "Type*",
                                'required'     => true,
                                'decorators' => $this->_textDecorator,
                                "data-rel" => "chosen"
                                ))
              
              ->addElement("Delete",
                          'entity_phone_delete_' . $this->_code,
                           array(
                             'required' => false,
                             'value' => $this->_deleteValue,
                             'decorators' => $this->_textDecorator,
                             'attribs'   => array ("contenedor" => "phone-content","title" => "Delete Phone"),
                             "data-rel" => "chosen"
                           ))
                             
             ->addElement("checkbox",
                          'entity_phone_default_' . $this->_code,
                           array(
                             'required' => false,
                             'value' => $this->_code,
                             'decorators' => $this->_checkboxDecorator,  
                             'attribs'   => array ("class" => "entity_checkbox_phone" ,"title"      => "Set Default Phone")))
              ->addElement("DivEnd",
                          'div_close_address'
                           );
        
        $this->_prepareForm();
    }
    
    /**
     * Carga los datos por defecto
     */
    protected function _prepareForm(){
        $type = New Dtz_Model_PhoneType();
        $phoneType = "entity_phone_type_" . $this->_code;
        $this->{$phoneType}->addMultiOptions(App_Utilitario_Form_Select::setFormat($type->getFieldTypes())); 
    }
}
?>
