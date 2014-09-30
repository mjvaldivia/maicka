<?php

class Letterart_Form_CategorySearch extends Vendor_Flex_Form_Search {
        
    /**
     * Nombre de la grilla asociada
     * @var string
     */
    protected $_grid_name = "letter_art_category";
    
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
                         "category_name", array(
                                        'label' => "Name",
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


