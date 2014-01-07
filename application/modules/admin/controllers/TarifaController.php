<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      MJ Valdivia<mj.valdivia@shorthillsolutions.com>
 */

class Admin_TarifaController extends App_Modulo_Mantenedor_Class{
        
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Tarifa";
    
    /**
     * Plan al cual pertenece la tarifa
     * @var \Model\Entity\Plan
     */
    protected $_plan;
    

    /**
     * Index
     */
    public function init() {
        parent::init();
        $this->_setPlan($this->_getParam("plan"));

    }
    
    public function indexAction() {
        parent::indexAction();
        $this->view->search_form = $this->_getSearchForm();
    }
    
    
    /**
     * Setea los campos de la tabla con los del formulario
     * @param \Model\Entity\Tarifa $entity
     * @param \Admin_Form_Tarifa $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setDiasdesde($form->getValue("desde"));
        $entity->setDiashasta($form->getValue("hasta"));
        $entity->setPlan($this->_plan);
        $entity->setPrecio($form->getValue("precio"));
        
    }
    
    /**
     * 
     * @param int $plan_id
     * @throws Exception
     */
    protected function _setPlan($plan_id){
        $plan = App_Doctrine_Action_Find::primary("Plan", $plan_id);
        if($plan instanceof \Model\Entity\Plan){
            $this->_plan = $plan;
            $this->view->id_plan   = $plan->getId();
            $this->view->plan_name = $plan->getName();
            
            $proveedor = $plan->getProveedor();
            $this->view->id_proveedor   = $proveedor->getId();
            $this->view->proveedor_name = $proveedor->getName();
        } else throw new Exception("No existe el plan");
    }
    
    /**
     * Carga los campos al formulario
     * @param \Admin_Form_Tarifa $form
     * @param \Model\Entity\Tarifa $entity
     */
    protected function _setEdit(&$form, $entity){     
        
        $form->desde->setValue($entity->getDiasdesde());
        $form->hasta->setValue($entity->getDiashasta());
        $form->precio->setValue($entity->getPrecio());
    }
    
    /**
     * Retorna la clase del formulario
     */
    protected function _getFormClass($parametros){
        $form = New Admin_Form_Tarifa($parametros);
        $form->renderForm();
        $form->plan->setValue($this->_plan->getId());
        return $form;
    }
    
    /**
     * Retorna URl de retorno
     * @return string
     */
    protected function _redirectUrl(){
        return "/" . $this->getRequest()->getModuleName() . "/" . $this->getRequest()->getControllerName() ."/index/plan/".$this->_plan->getId();
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
        $form = New Admin_Form_SearchTarifa($parametros);
        $form->renderForm();

        return $form;
    }
    
}
?>
