<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Admin_Form_Tarifa extends App_Utilitario_Forms{
    /**
     * Inicia y configura el formulario
     */
    public function init() {
        parent::init();
    }
    
    /**
     * Carga los elementos del formulario
     */
    public function renderForm() {
        $this->_getElements();
    }

    /**
     * Genera los campos del formulario
     */
    protected function _getElements() {
        $this->addElement("hidden", 
                          "id", array(
                                        'required' => false,
                                        'decorators' => $this->_hiddenDecorator,
                                        )
                          )
             ->addElement("hidden", 
                          "plan", array(
                                        'required' => false,
                                        'decorators' => $this->_hiddenDecorator,
                                        )
                          )
             ->addElement("text", 
                          "desde", array(
                                        'label' => "Desde día",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge"),
                                        'filters' => array('StringTrim')
                                        )
                          )
             ->addElement("text", 
                          "hasta", array(
                                        'label' => "Hasta día",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("text", 
                         "precio", array(
                                        'label' => "Precio",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("Mensaje", 
                         "mensaje", 
                          array()
                          )
            ->addElement("FormAction", 
                         "buttons", array()
                          );
    }
    
    
}
?>
