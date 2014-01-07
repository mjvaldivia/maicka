<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Admin_LoginController extends Zend_Controller_Action{
    
    /**
     * Init
     * Inicia el helper para logeo
     */
    public function init() {
        Zend_Controller_Action_HelperBroker::addPath(LIBRARY_PATH.'/App/Modulo/Login/Action/Helpers', 'Helper');
        $this->_helper->login->setEntity("Adminuser");
        $this->_helper->login->setUserField("username");
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
     * Procesa el formulario de login
     */
    public function processAction(){
        try{
            $resultado = $this->_helper->login->process();
            if($resultado){
                $usuario    = $this->_helper->login->getUser();

                $this->_helper->login->writeStorage();
                fb("Guardo login");
                $this->_redirect($this->_helper->login->getUrlRetorno());
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
        $this->view->module      = $this->getRequest()->getModuleName();
        $this->view->mensaje     = $this->_helper->login->getMensaje();
        $this->view->request_url = $this->_helper->login->getUrlRetorno();
    }
}
?>
