<?php

class Order_Form_OrderSearch extends Vendor_Flex_Form_Search {
    
    /**
     * Nombre de la grilla asociada
     * @var string
     */
    protected $_grid_name = "orders_list";
    
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
        $this->_populateStatus();
        $this->_recordarBusqueda();
    }
    
    /**
     * Genera los campos del formulario
     */
    protected function _getElements() {
        $this->addElement("text", 
                          "order_id", array(
                                        'label' => "Id",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("text", 
                          "customer_name", array(
                                        'label' => "Customer",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control element-search")
                                        )
                          )
             ->addElement("select", 
                          "status", array(
                                        'label' => "Status",
                                        'required' => true,
                                        'decorators' => $this->_text_decorator,
                                        'attribs' => array("class" => "form-control chosen element-search")
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
    
    /**
     * 
     */
    protected function _populateStatus(){
        $list = App_Doctrine_Action_Query::fetchAll("OrderStatus", "findAll");
        $this->status->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
    
}

