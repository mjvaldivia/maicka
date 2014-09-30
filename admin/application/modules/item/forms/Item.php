<?php

class Item_Form_Item extends Vendor_Flex_Form_Normal {
    
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
       // $this->activo->setValue("checked");

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
                         "name", array(
                                        'label' => "Name",
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
                         "quantity", array(
                                        'label' => "Letter Quantity",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
             ->addElement("text", 
                         "price_cdn", array(
                                        'label' => "Price CDN",
                                        'required' => false,
                                        'decorators' => $this->getMoneyDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
             ->addElement("text", 
                         "price_usa", array(
                                        'label' => "Price USA",
                                        'required' => false,
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

