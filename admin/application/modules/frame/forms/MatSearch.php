<?php

class Frame_Form_MatSearch extends Vendor_Flex_Form_Search {
    
    /**
     * Nombre de la grilla asociada
     * @var string
     */
    protected $_grid_name = "mat_list";
    
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
                          "mat_id", array(
                                        'label' => "Id",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("text", 
                          "mat_name", array(
                                        'label' => "Name",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("text", 
                          "mat_frame", array(
                                        'label' => "Frame",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("button", 
                         "search_" . $this->_grid_name, array(
                                        'label' => "Search",
                                        'required' => false,
                                        'decorators' => $this->_button_decorator,
                                        'attribs' => array("class" => "btn btn-white search-button")
                                        )
                          );
           
    }
    
}
