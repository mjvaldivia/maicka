<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Admin_Form_Zona extends App_Utilitario_Forms{
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
        
        $this->_llenaPaises();
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
             ->addElement("text", 
                          "name", array(
                                        'label' => "Nombre",
                                        'required' => true,
                                        'decorators' => $this->_textDecorator,
                                        'attribs' => array("class" => "input-xlarge"),
                                        'filters' => array('StringTrim')
                                        )
                          )
            ->addElement("multiselect", 
                          "zona_pais", array(
                                        'label' => "Motivos del viaje",
                                        'required' => false,
                                        'decorators' => $this->_text_big_decorator,
                                        'attribs' => array(
                                                           "style" => "width: 600px",
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
                         "buttons", 
                          array()
                          );
    }
    
    protected function _llenaPaises(){
        $proveedor_model = App_Doctrine_Repository::repository("Pais");
        $list            = $proveedor_model->listOrderByName();
        if(count($list)>0)
            $this->zona_pais->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
    }
}
?>
