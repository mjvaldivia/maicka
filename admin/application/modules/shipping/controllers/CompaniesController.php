<?php

class Shipping_CompaniesController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "ShippingCompany";
    
    /**
     * Init
     */
    public function init() {
        parent::init();
    }
    
    /**
     * Index
     */
    public function indexAction() {
        $form = new Shipping_Form_CompanySearch(array('name'    => "search_companies_list"));
        $form->renderForm();
        $this->view->form = $form;
    }
    
     /**
     * 
     * @param \Shipping_Form_Company $form
     */
    protected function _setNew(&$form){
   
    }
    
    /**
     * 
     * @param \Shipping_Form_Company $form
     * @param \Model\Entity\ShippingCompany $entity
     */
    protected function _setEdit(&$form, $entity){


        
        $form->name->setValue($entity->getName());
        $form->url->setValue($entity->getTrackUrl());
        

    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\ShippingCompany $entity
     * @param \Shipping_Form_Company $form
     */
    protected function _setProcess(&$entity, $form){
        
        
        $entity->setName($form->getValue("name"));
        $entity->setTrackUrl($form->getValue("url"));
    }
        
    /**
     * Retorna la clase que arma el formulario
     * @return \Shipping_Form_Company
     */
    protected function _getFormClass($parametros){
        $form = New Shipping_Form_Company($parametros);
        $form->renderForm();
        return $form;
    }
    
}


