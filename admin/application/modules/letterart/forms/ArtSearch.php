<?php

class Letterart_Form_ArtSearch extends Vendor_Flex_Form_Search {
    
    protected $_grid_name = "letterart";
    
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
                          "art_id", array(
                                        'label' => "Id",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("text", 
                          "art_name", array(
                                        'label' => "Name",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("text", 
                          "art_letter", array(
                                        'label' => "Letter",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("text", 
                          "art_category", array(
                                        'label' => "Category",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("button", 
                         "search_" . $this->_grid_name, array(
                                        'label' => "Search",
                                        'required' => true,
                                        'decorators' => $this->_button_decorator,
                                        'attribs' => array("class" => "btn btn-white search-button")
                                        )
                          );
           
    }
    
}
