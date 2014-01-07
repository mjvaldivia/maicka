<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
Class Admin_Form_SearchOrdenes extends App_Utilitario_Forms{
    
        /**
     * Carga los elementos del formulario
     */
    public function renderForm() {
        $this->_getElements();
        $this->_populateProveedor();
        $this->_populateEstado();
    }
    
    
    
     /**
     * Genera los campos del formulario
     */
    protected function _getElements() {
        $this->addElement("text", 
                          "ordenId", array(
                                        'label' => "Numero Orden",
                                        'required' => true,
                                        'decorators' => $this->_text_min_Decorator,
                                        'attribs' => array("class" => "input-100"),
                                        'filters' => array('StringTrim')
                                       )
                          )
            ->addElement("text", 
                         "planId", array(
                                            'label' => "Plan",
                                            'required' => true,
                                            'decorators' => $this->_text_min_Decorator,
                                            'attribs' => array("class" => "input-100")
                                            )
                        )
            ->addElement("text", 
                         "compradorId", array(
                                            'label' => "Comprador",
                                            'required' => true,
                                            'decorators' => $this->_text_min_Decorator,
                                            'attribs' => array("class" => "input-100")
                                            )
                        )
            ->addElement("select", 
                         "proveedorId", array(
                                            'label' => "Proveedor",
                                            'required' => true,
                                            'decorators' => $this->_text_min_Decorator,
                                            'attribs' => array("class" => "input-100 country",
                                                               "rel" => "search_province",
                                                               "data-rel" => "chosen")
                                            )
                        )
            ->addElement("select", 
                         "statusId", array(
                                            'label' => "Estado",
                                            'required' => true,
                                            'decorators' => $this->_text_min_Decorator,
                                            'attribs' => array("class" => "input-100","data-rel" => "chosen")
                                            )
                        )

            ->addElement("SearchButton", 
                         "buttons", 
                          array('attribs' => array("onclick" => "$('#ordenes').flexReload()"))
                          );
    }
    
    /**
     * Llena el proveedor
     */
    protected function _populateProveedor(){
        $proveedor_model = App_Doctrine_Repository::repository("Proveedor");
        $list = $proveedor_model->listAllOrderByNombre();
        $this->proveedorId->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName")); 
    }
    
    protected function _populateEstado(){
        $status_model = App_Doctrine_Repository::repository("OrdenStatus");
        $list = $status_model->listAllOrderByNombre();
        $this->statusId->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName")); 
    }
    
}

?>
