<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Module_Entities_Manager_Entity_Form_Name extends App_Form_Decorator_Abstract{
    public function init() {
        parent::init();
        $this->setDecorators(array('FormElements'));
        
        $this->_render();
    }
    
    protected function _render(){
         $this->addElement("DivStart",
                          'div_name_start',
                            array(
                                'attribs'      => array("class"=>"div-form-row")
                            ))
              ->addElement("hidden",
                           "entity_id",
                            array(
                                'required'     => false,
                                'decorators' => $this->_hiddenDecorator
                            ))
              ->addElement("text",
                           "name",
                            array(
                                'label' => "Name*",
                                'required'     => true,
								'attribs'      => array("class"=>"name-form"),
                                'decorators' => $this->_textDecorator
                            ))
              ->addElement("checkbox", 
                         "company", array(
                                        'label' => "Company",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("data-no-uniform" => "true", "class" => "iphone-toggle"),
                                        'filters' => array('StringTrim')
                                        )
                          )
              ->addElement("DivEnd",
                          'div_name_end',
                            array(
                                'attribs'      => array("class"=>"div-form-row")
                            ));
    }
}
?>
