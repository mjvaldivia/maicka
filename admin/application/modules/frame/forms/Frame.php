<?php

class Frame_Form_Frame extends Vendor_Flex_Form_Normal {
    
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
        $this->activo->setValue("checked");

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
            ->addElement("FlexCheckbox", 
                         "activo", array(
                                        'label' => "Active",
                                        'required' => false,
                                        'attribs' => array()
                                        )
                          )
            ->addElement("FlexCheckbox", 
                         "default", array(
                                        'label' => "Default",
                                        'required' => false,
                                        'attribs' => array()
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
    
}

