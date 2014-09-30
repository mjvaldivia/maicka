<?php

class Order_Form_Detail extends Vendor_Flex_Form_Normal {
    
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
        $this->_populateFrame();
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
            ->addElement("hidden", 
                          "order", array(
                                        'required' => false,
                                        'attribs' => array()
                                        )
                          )
            ->addElement("text", 
                         "quantity", array(
                                        'label' => "Quantity",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("text", 
                         "word", array(
                                        'label' => "Word",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("text", 
                         "letters", array(
                                        'label' => "Letter Choices",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("select", 
                         "frame", array(
                                        'label' => "Frame",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control chosen")
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
    protected function _populateFrame(){
        $repository = App_Doctrine_Repository::repository("Frame");
        $list = $repository->listAllOrder();
        $this->frame->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
        
}


