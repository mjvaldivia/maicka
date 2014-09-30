<?php

class Item_Form_ItemSearch extends Vendor_Flex_Form_Search {
    
    /**
     * Nombre de la grilla asociada
     * @var string
     */
    protected $_grid_name = "item_master";
    
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
        $this->_recordarBusqueda();
    }
    
    /**
     * Genera los campos del formulario
     */
    protected function _getElements() {
        $this->addElement("text", 
                          "item_name", array(
                                        'label' => "Name",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("text", 
                          "item_frame", array(
                                        'label' => "Frame",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("button", 
                         "search-" . $this->_grid_name, array(
                                        'label' => "Search",
                                        'required' => true,
                                        'decorators' => $this->_button_decorator,
                                        'attribs' => array("class" => "btn btn-white search-button")
                                        )
                          );
           
    }
    
}

