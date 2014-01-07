<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Admin_Form_Plan extends App_Utilitario_Forms{
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
        $this->_llenaMotivo();
        $this->_llenaZonas();
    }

    /**
     * Genera los campos del formulario
     */
    protected function _getElements() {
        $this->addElement("hidden", 
                          "id", array(
                                        'required' => false,
                                        'decorators' => $this->_hiddenDecorator,
                                        )
                          )
             ->addElement("hidden", 
                          "proveedor", array(
                                        'required' => true,
                                        'decorators' => $this->_hiddenDecorator,
                                        )
                          )
             ->addElement("text", 
                          "plan_nombre", array(
                                        'label' => "Nombre del plan",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("archivo", 
                          "plan_archivo", array(
                                        'label' => "Cobertura",
                                        'required' => false,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("filename" => "",
                                                           "data-rel" => "tooltip", 
                                                           "class" => "input-file",
                                                           "title" => "Subir archivo"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("text", 
                         "plan_description", array(
                                        'label' => "Descripcion",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("style" => "height: 144px; width: 100%"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("text", 
                          "plan_sobrecargo", array(
                                        'label' => "Sobrecargo",
                                        'required' => false,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("text", 
                          "plan_edad", array(
                                        'label' => "Edad maxima",
                                        'required' => false,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("multiselect", 
                          "plan_motivo", array(
                                        'label' => "Motivos del viaje",
                                        'required' => false,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge",
                                                           "data-rel" => "chosen"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("select", 
                          "plan_zona", array(
                                        'label' => "Zona",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge",
                                                           "data-rel" => "chosen"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("checkbox", 
                         "active", array(
                                        'label' => "Activo",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("data-no-uniform" => "true", "class" => "iphone-toggle"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("Mensaje", 
                         "mensaje", 
                          array()
                          )
            ->addElement("FormAction", 
                         "buttons", array()
                          );
    }
    
    
     protected function _llenaMotivo(){
        $proveedor_model = App_Doctrine_Repository::repository("MotivoViaje");
        $list            = $proveedor_model->findAll();
        if(count($list)>0)
            $this->plan_motivo->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
    
    protected function _llenaZonas(){
        $proveedor_model = App_Doctrine_Repository::repository("Zona");
        $list            = $proveedor_model->findAll();
        if(count($list)>0)
            $this->plan_zona->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
}
?>
