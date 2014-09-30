<?php

class Letterart_CategoryController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "LetterCategory";
    
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
        $form = new Letterart_Form_CategorySearch(array('name'    => "search_letter_art_category"));
        $form->renderForm();
        $this->view->form = $form;
    }
    
     /**
     * 
     * @param \Letterart_Form_Category $form
     */
    protected function _setNew(&$form){
        //$form->active->setValue(true);
    }
    
    /**
     * 
     * @param \Letterart_Form_Category $form
     * @param \Model\Entity\LetterCategory $entity
     */
    protected function _setEdit(&$form, $entity){
        $form->id->setValue($entity->getId());
        $form->name->setValue($entity->getName());
        $form->activo->setValue($entity->getActive());
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\LetterCategory $entity
     * @param \Letterart_Form_Category $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setName($form->getValue("name"));
        $entity->setActive($form->getValue("activo"));
    }
        
    /**
     * Retorna la clase que arma el formulario
     * @return \Zend_form
     */
    protected function _getFormClass($parametros){
        $form = New Letterart_Form_Category($parametros);
        $form->renderForm();
        return $form;
    }
}

