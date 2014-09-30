<?php

class Letterart_Form_Art extends Vendor_Flex_Form_Normal {
    
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
        $this->_populateCategory();
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
             ->addElement("Imagen", 
                         "art", array(
                                        'label' => "Art",
                                        'required' => false,
                                        'attribs' => array("class" => "")
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
            ->addElement("text", 
                         "letter", array(
                                        'label' => "Letter",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control")
                                        )
                          )
            ->addElement("select", 
                         "category", array(
                                        'label' => "Art Category",
                                        'required' => true,
                                        'decorators' => $this->getTextDecorator(),
                                        'attribs' => array("class" => "form-control chosen")
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
    
    /**
     * LLena combo de categoria
     */
    protected function _populateCategory(){
        $repository = App_Doctrine_Repository::repository("LetterCategory");
        $list = $repository->listAllOrder();
        $this->category->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
}

