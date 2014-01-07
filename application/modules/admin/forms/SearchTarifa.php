<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Admin_Form_SearchTarifa extends App_Utilitario_Forms{
    
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
                         "dia", array(
                                    'label' => "Día",
                                    'required' => true,
                                    'decorators' => $this->_text_min_Decorator,
                                    'attribs' => array("class" => "input-100")
                                    )
                        )
           


            ->addElement("SearchButton", 
                         "buttons", 
                          array('attribs' => array("onclick" => "$('#tarifas').flexReload()"))
                          );
    }
    
    
}
?>
