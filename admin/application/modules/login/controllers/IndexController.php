<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Login_IndexController extends Zend_Controller_Action{
    
    /**
     * Init
     * Inicia el helper para logeo
     */
    public function init() {
        $this->_helper->layout->disableLayout();
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/login/library/Action/Helpers', 'Helper');
        $this->_helper->login->setEntity("Entities");
        $this->_helper->login->setUserField("login");
        $this->_helper->login->setPasswordField("password");
        
        //le dice a la vista que tipo de mensaje mostrar
        $this->view->correcto = true;
    }
    
    /**
     * Carga formulario
     */
    public function indexAction(){
        $this->_helper->login->index();
        $this->_setVista();
    }
    
    /**
     * Deslogear
     */
    public function logoutAction(){
        Zend_Auth::getInstance()->clearIdentity();
        setcookie("usuario", "", time() + 60 * 60 * 24 * 30, "/");
        
        $this->_redirect("/default");
    }
    
    /**
     * Procesa el formulario de login
     */
    public function processAction(){
        try{
            $resultado = $this->_helper->login->process();
            if($resultado){
               $usuario    = $this->_helper->login->getUser();
               $entity_type = $usuario->getEntityType();
               //print_r($entitytype);
               if($entity_type->getId() == 1){
                       $this->_helper->login->writeStorage();
                       fb("Guardo login");
                       $this->_redirect($this->_helper->login->getUrlRetorno());
                   
               } else throw new Exception("You don't have permissions to access this module");
            } else throw new Exception("");
        } catch (Exception $e){
            if($e->getMessage()!=""){
                $this->_helper->login->setMensaje($e->getMessage());
            }
            $this->view->correcto = false;
            $this->_setVista();
            return $this->render("index");
        }
    }
    
    /**
     * Setea las variables en vista
     */
    protected function _setVista(){
        $this->view->action      = $this->_helper->login->getAction();
        $this->view->mensaje     = $this->_helper->login->getMensaje();
        $this->view->request_url = $this->_helper->login->getUrlRetorno();
    }
}
