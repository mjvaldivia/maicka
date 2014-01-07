<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Entitymanager_ProvinceController extends Zend_Controller_Action{
    /**
    * Actions llamados por ajax
    * @var array
    */
   public $ajaxable = array("combo-load" => array("json"));
   
   /**
    *
    * @var /Model/Entity/Country 
    */
   protected $_countryManager;
   
   /**
    * Inicia el controlador
    */
   public function init(){
        $this -> _helper -> getHelper('AjaxContext') -> initContext();     
        $this->_countryManager = App_Doctrine_Repository::repository("Country");
   } 
   
   /**
    * Devuelve las provincias asociadas al pais 
    */
   public function comboLoadAction(){
       
       $salida = array();
       
       $request = $this->getRequest();
       $countryId = $request->getParam("id");
       $country = $this->_countryManager->find($countryId);
       if($country){
          $states = $country->listStates();
          foreach($states as $province){
              $salida[$province->getId()] = $province->getName();
          }
          
          
       } 
       
       $this->view->province = $salida;
   }
}
?>
