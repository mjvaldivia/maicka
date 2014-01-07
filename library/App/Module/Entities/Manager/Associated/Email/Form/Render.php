<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Associated_Email_Form_Render extends App_Module_Entities_Manager_Associated_Abstract{
     public function _createElements() {
  
        $this->addElement("DivStart",
                          'div_address',
                            array(
                                    'attribs'      => array("class"=>"div-email div-form-row" . $this->_deleteClass)
                            ))
              ->addElement("hidden",
                           "entity_email_code",
                           array(
                                'isArray' => true,
                                'value' => $this->_code,
                                'decorators' => $this->_hiddenDecorator)
                           )
              ->addElement("hidden",
                           "entity_email_id_" . $this->_code,
                           array('decorators' => $this->_hiddenDecorator)
                           )
              ->addElement("text",
                           "entity_email_address_" . $this->_code,
                            array(
                                'label' => "Email*",
                                'required'     => true,
                                'validators' => array(
                                                      array('EmailAddress')
                                                     ),
                                'decorators'   => $this->_textDecorator
                                ))
 
 
 
 
              ->addElement("select",
                           "entity_email_type_" . $this->_code,
                            array(
                                'label' => "Type*",
                                'required'     => true,
                                'decorators' => $this->_textDecorator,
                                "data-rel" => "chosen"
                                ))
              ->addElement("Delete",
                          'entity_email_delete_' . $this->_code,
                           array(
                             'required' => false,
                             'value' => $this->_deleteValue,
                             'attribs'   => array ("contenedor" => "email-content", "title" => "Delete Email"),
                             'decorators'   => $this->_textDecorator))
               ->addElement("checkbox",
                          'entity_email_default_' . $this->_code,
                           array(
                             'required' => false,
                             'value' => $this->_code,
                             'attribs'   => array ("class" => "entity_checkbox_email" ,"title" => "Set Default Email"),
                             'decorators'   => $this->_checkboxDecorator))
              ->addElement("DivEnd",
                          'div_close_address'
                           );
        
        $this->_prepareForm();
    }
    
    /**
     * Genera los datos por defecto del formulario
     */
    protected function _prepareForm(){
         $type = New Dtz_Model_EmailType();
         $emailType = "entity_email_type_" . $this->_code;
         $this->{$emailType}->addMultiOptions(App_Utilitario_Form_Select::setFormat($type->getFieldTypes())); 
        
    
    }
}
?>
