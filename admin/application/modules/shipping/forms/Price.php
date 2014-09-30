<?php

class Shipping_Form_Price extends Vendor_Flex_Form_Normal {
    
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
        $this->_populateCountry();

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
            ->addElement("text", 
                         "price", array(
                                        'label' => "Price",
                                        'required' => true,
                                        'decorators' => $this->getMoneyDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("select", 
                         "country", array(
                                        'label' => "Country",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control chosen")
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
     * LLena combo de categoria
     */
    protected function _populateCountry(){
        $repository = App_Doctrine_Repository::repository("Country");
        $list = $repository->listAllOrder();
        $this->country->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
    
}

