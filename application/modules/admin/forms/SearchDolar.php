<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Admin_Form_SearchDolar extends App_Utilitario_Forms{
    
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
        $this->addElement("text", 
                         "fecha", array(
                                    'label' => "Fecha",
                                    'required' => true,
                                    'decorators' => $this->_text_min_Decorator,
                                    'attribs' => array("class" => "input-100 datepicker")
                                    )
                        )
           


            ->addElement("SearchButton", 
                         "buttons", 
                          array('attribs' => array("onclick" => "$('#dolar').flexReload()"))
                          );
    }
    

}
?>
