<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Admin_Form_Dolar extends App_Utilitario_Forms{
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
             ->addElement("text", 
                          "fecha_inicio", array(
                                        'label' => "Fecha inicio",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge datepicker"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("text", 
                          "fecha_termino", array(
                                        'label' => "Fecha termino",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge datepicker"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("text", 
                          "valor", array(
                                        'label' => "Valor",
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
                         "buttons", 
                          array()
                          );
    }
    
}
?>
