<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Admin_OrdenesController extends App_Modulo_Mantenedor_Class{
    
       /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Orden";
    
    public function init() {
        parent::init();
    }
    
    /**
     * Buscador de ordenes
     */
    public function indexAction(){
        $this->view->search_form = $this->_getSearchForm();
    }
    
    /**
     * Ver orden
     */
    public function verAction(){
        $orden_id = $this->_getParam("id");
        $this->view->orden_id = $orden_id;
    }
    
    /**
     * Formulario de busqueda
     * @return \Admin_Form_SearchOrdenes
     */
    protected function _getSearchForm(){
        $parametros = array(
                            'name'    => 'search',
                            'action'  => "",
                            'method'  => 'post',
                            'prefixPath' => array("path" => "App/Utilitario/Form",
                                                  "prefix" => "App_Utilitario_Form",
                                                  "type"   => \Zend_Form::ELEMENT)
                           );
        
        
        $form = New Admin_Form_SearchOrdenes($parametros);
        $form->renderForm();
        return $form;
    }
}
?>
