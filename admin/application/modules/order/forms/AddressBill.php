<?php

class Order_Form_AddressBill extends Vendor_Flex_Form_Normal {
    
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
        $this->_populateCustomer();
        $this->_populateState();
    }
    
    /**
     * Genera los campos del formulario
     */
    protected function _getElements() {
        $this->addElement("hidden", 
                          "id", array(
                                        'required' => false,
                                        'attribs' => array()
                                        )
                          )
            ->addElement("select", 
                         "customer", array(
                                        'label' => "Customer",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control chosen")
                                        )
                          )    
            ->addElement("text", 
                         "address", array(
                                        'label' => "Address",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("text", 
                         "city", array(
                                        'label' => "City",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("select", 
                         "state", array(
                                        'label' => "State/Province",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control chosen")
                                        )
                          )
            ->addElement("text", 
                         "postal", array(
                                        'label' => "Postal",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("Mensaje", 
                         "mensaje", array(
                                        'required' => false
                                        )
                          )
            ->addElement("FormAction", 
                         "buttons", array(
                                        'label' => "",
                                        'required' => false,
                                        'attribs' => array()
                                        )
                          );
    }
    
    /**
     * 
     */
    protected function _populateState(){
        $list = App_Doctrine_Action_Query::fetchAll("State", "listAllOrder");
        $this->state->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getCountryState"));
    }
    
    /**
     *
     */
    protected function _populateCustomer(){
        $list = App_Doctrine_Action_Query::fetchAll("Entities", "listAllCustomer");
        $this->customer->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
}

