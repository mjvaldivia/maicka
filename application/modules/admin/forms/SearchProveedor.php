<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Admin_Form_SearchProveedor extends App_Utilitario_Forms{
    
        /**
     * Carga los elementos del formulario
     */
    public function renderForm() {
        $this->_getElements();
        $this->_populateActive();
    }
    
    
    
     /**
     * Genera los campos del formulario
     */
    protected function _getElements() {
        $this->addElement("text", 
                         "proveedor_name", array(
                                    'label' => "Nombre",
                                    'required' => true,
                                    'decorators' => $this->_text_min_Decorator,
                                    'attribs' => array("class" => "input-100")
                                    )
                        )
           
            ->addElement("select", 
                         "proveedor_active", array(
                                            'label' => "Activo",
                                            'required' => true,
                                            'decorators' => $this->_text_min_Decorator,
                                            'attribs' => array("class" => "input-100","data-rel" => "chosen")
                                            )
                        )

            ->addElement("SearchButton", 
                         "buttons", 
                          array('attribs' => array("onclick" => "$('#proveedor').flexReload()"))
                          );
    }
    
    /**
     * Llenar combo activo
     */
    protected function _populateActive(){
        $array = array("" => "",0 => "No", 1 => "Si");
        $this->proveedor_active->addMultiOptions($array); 
    }
    
}
?>
