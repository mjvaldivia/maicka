<?php

class Frame_IndexController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Frame";
    
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
        $form = new Frame_Form_FrameSearch(array('name'    => "search_frame_list"));
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
        $form->populate(array(
            "id" => $entity->getId(),
            "name" => $entity->getName(),
            "activo" => $entity->getActive(),
            "default" => $entity->getDefault()
        ));
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\LetterCategory $entity
     * @param \Letterart_Form_Category $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setName($form->getValue("name"));
        $entity->setActive($form->getValue("activo"));
        
        if ($form->getValue("default") == 1) {
            App_Doctrine_Repository::repository("Frame")->resetDefault();
        }
        
        $entity->setDefault($form->getValue("default"));
    }
        
    /**
     * Retorna la clase que arma el formulario
     * @return \Zend_form
     */
    protected function _getFormClass($parametros){
        $form = New Frame_Form_Frame($parametros);
        $form->renderForm();
        return $form;
    }
}

