<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

/**
 * Template para mantenedores
 */
class App_Modulo_Mantenedor_Class extends Zend_Controller_Action{
    
     /**
     * Actions llamados por ajax
     * @var array 
     */
    public $ajaxable = array("delete" => array("json"));
    
    /**
     * @var type 
     */
    protected $_entity_manager;
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity;
    
    /**
     * init
     */
    public function init() {
        $this ->_helper->getHelper('AjaxContext')->initContext();
        $this->_entity_manager = App_Doctrine_Repository::entityManager();
        
        $this->view->addHelperPath(LIBRARY_PATH . '/App/Modulo/Mantenedor/Helpers', 'Zend_View_Helper');
    }
    
    /**
     * Lista
     */
    public function indexAction(){
        
    }
    
    
    
    /**
     * Ingresa nuevo
     */
    public function newAction(){
        $form = $this->_getForm();
        $this->_setNew($form);
        $this->_setFormJs();
        $this->view->form = $form;
        $this->view->redirect_url = $this->_redirectUrl();
    }
    
    /**
     * Edita el proveedor
     */
    public function editAction(){
        $request = $this->getRequest();
        $entity = App_Doctrine_Action_Find::primary($this->_entity, $request->getParam("id"));
        if($entity){
           $form = $this->_getForm();
           $form->id->setValue($entity->getId());
           $this->_setEdit($form, $entity);
           $this->view->form = $form;
           $this->_setFormJs();
           $this->view->redirect_url = $this->_redirectUrl();
           return $this->render("new");
        }
    }
    
     /**
     * 
     * @param  $form
     */
    protected function _setNew(&$form){
        
    }
    
    /**
     * @return type 
     */
    public function procesarAction(){
        $request = $this->getRequest();
        
      
        $form = $this->_getForm();
        $this->_setPreValidForm($form);
        if($form->isValid($request->getParams())){
            $result = App_Doctrine_Action_Find::primary($this->_entity, $request->getParam("id"));
            if($result){
                $entity = $result;
            } else {
               eval("\$entity = New \\Model\\Entity\\" . $this->_entity . "();");
            }
            
            $this->_setProcess($entity, $form);
            $this->_entity_manager->persist($entity);
           // $this->_entity_manager->
            $this->_entity_manager->flush();
            //$this->_entity_manager->refresh($entity);
            $this->_setPostProcess($entity, $form);
            $this->view->error = false;
            return $this->_render();
            
        } else {
            
            $this->_setPostError($form);
            $this->view->error = true;
            $this->_setFormJs();
            $form->processErrors();
            $form->mensaje->setAttrib("error", true);
            $this->view->form = $form;
            return $this->render("new");
        }
    }
    
    /**
     * Eliminar 
     */
    public function deleteAction(){
        $id = $this->_getParam("id");
        $entity = App_Doctrine_Action_Find::primary($this->_entity, $id);
        if($entity){
           $this->_entity_manager->remove($entity);
           $this->_entity_manager->flush();
        }
    }
        
    /**
     * Setea los campos
     * @param \Model\Entity $entity
     */
    protected function _setProcess(&$entity, $form){
        
    }
    
    /**
     * Setea campos especiales
     * @param \Model\Entity $entity
     */
    protected function _setPostProcess(&$entity, $form){        

    }
    
    /**
     * 
     * @param \Model\Entity $entity
     * @param type $form
     */
    protected function _setPostError($form){
        
    }
    
    /**
     * Se ejecuta antes de validar el formulario
     */
    protected function _setPreValidForm(&$form){
        
    }
    
    /**
     * 
     * @param \Zend_Form $form
     * @param \Model\Entity\ $entity
     */
    protected function _setEdit(&$form, $entity){
        
    }
    
    /**
     * @return \Zend_Form
     */
    protected function _getForm(){    
       
        $parametros = array(
                            'name'    => 'mantenedor',
                            'action'  => "/" . $this->getRequest()->getModuleName(). "/" . $this->getRequest()->getControllerName() . "/procesar",
                            'method'  => 'post',
                            'class'   => "form-horizontal",
                            'prefixPath' => array("path" => "App/Utilitario/Form",
                                                  "prefix" => "App_Utilitario_Form",
                                                  "type"   => \Zend_Form::ELEMENT)
                           );
        
        $form = $this->_getFormClass($parametros);

       
        $form->buttons->setAttrib("cancel", $this->_redirectUrl());
        return $form;
    }
    
    /**
     * Setea archivos JS necesarios para el formulario
     */
    protected function _setFormJs(){
        
    }
    
    /**
     * Retorna la clase que arma el formulario
     * @return \Zend_form
     */
    protected function _getFormClass($parametros){
        
    }
    
    /**
     * Redirecciona despues de guardar 
     * @return 
     */
    protected function _render(){
        return $this->_redirect($this->_redirectUrl());
    }
    
    /**
     * Retorna URl de retorno
     * @return string
     */
    protected function _redirectUrl(){
        return "/" . $this->getRequest()->getModuleName() . "/" . $this->getRequest()->getControllerName() ."/index";
    }
}
?>
