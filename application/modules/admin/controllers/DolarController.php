<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      MJ Valdivia<mj.valdivia@shorthillsolutions.com>
 */

class Admin_DolarController extends App_Modulo_Mantenedor_Class{
        
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Dolar";
       
    public function indexAction() {
        parent::indexAction();
        $this->view->search_form = $this->_getSearchForm();
    }
    
    
    /**
     * Setea los campos de la tabla con los del formulario
     * @param \Model\Entity\Dolar $entity
     * @param \Admin_Form_Dolar $form
     */
    protected function _setProcess(&$entity, $form){
        $inicio = DateTime::createFromFormat('m/d/Y', $form->getValue("fecha_inicio"));
        $termino = DateTime::createFromFormat('m/d/Y', $form->getValue("fecha_termino"));

        if($inicio instanceof DateTime){
            $entity->setInicio($inicio);
        }

        if($termino instanceof DateTime){
            $entity->setTermino($termino);
        }
        
        
        $entity->setMoneda($form->getValue("valor"));
    }
        
    /**
     * Carga los campos al formulario
     * @param \Admin_Form_Dolar $form
     * @param \Model\Entity\Dolar $entity
     */
    protected function _setEdit(&$form, $entity){     
        
        $form->fecha_inicio->setValue($entity->getFechaInicio());
        $form->fecha_termino->setValue($entity->getFechaTermino());
        $form->valor->setValue($entity->getMoneda());
        
    }
    
    /**
     * Retorna la clase del formulario
     */
    protected function _getFormClass($parametros){
        $form = New Admin_Form_Dolar($parametros);
        $form->renderForm();
        return $form;
    }
    
    /**
     * Retorna URl de retorno
     * @return string
     */
    protected function _redirectUrl(){
        return "/" . $this->getRequest()->getModuleName() . "/" . $this->getRequest()->getControllerName() ."/index";
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
        $form = New Admin_Form_SearchDolar($parametros);
        $form->renderForm();

        return $form;
    }
    
}
?>
