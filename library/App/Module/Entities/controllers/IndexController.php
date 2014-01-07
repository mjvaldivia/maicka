<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Entitymanager_IndexController extends Zend_Controller_Action{
    
   /**
    * Entity manager de doctrine
    * @var type 
    */
   protected $_entityManager;
   
   /**
    * Actions llamados por ajax
    * @var array
    */
   public $ajaxable = array("add-address" => array("html"),
                            "add-phone"   => array("html"),
                            "add-contact" => array("html"),
                            "add-email"   => array("html"));
   
   /**
    * Inicia el controlador
    */
   public function init(){
        $this -> _helper -> getHelper('AjaxContext') -> initContext();              
        $this->_entityManager  = Zend_Registry::get('doctrine')->getEntityManager(); 
   } 
   
   /**
    * Add one phone line
    * @return type 
    */
   public function addPhoneAction(){        
       $phone = New App_Module_Entities_Manager_Associated_Phone_Actions_Load();
       $phone->isAddline();
       $this->view->form = $phone->getForm(); 
   }
   
   /**
    * Add one phone line
    * @return type 
    */
   public function addEmailAction(){        
       $email = New App_Module_Entities_Manager_Associated_Email_Actions_Load();
       $email->isAddline();
       $this->view->form = $email->getForm(); 
   }
   
   /**
    * Añade una linea del 
    * formulario de direcciones
    */
   public function addAddressAction(){
       $address = New App_Module_Entities_Manager_Associated_Address_Actions_Load();
       $address->isAddline();
       $this->view->form = $address->getForm(); 
   }
}
?>
