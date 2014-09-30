<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Order_AddressShipController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "OrderHeader";
        
    
    public function init() {
        parent::init();
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/order/library/Action/Helpers', 'Helper');
    }
    
    /**
     * Setea campos especiales
     * @param \Model\Entity\OrderHeader $entity
     * @param \Order_Form_AddressShip $form
     */
    protected function _setPostProcess(&$entity, $form){        
        $this->_helper->Update->totales($entity->getId());
    }
    
    /**
     * 
     * @param \Order_Form_AddressShip $form
     * @param \Model\Entity\OrderHeader $entity
     */
    protected function _setEdit(&$form, $entity){
        

        
        $form->address->setValue($entity->getShipStreet());
        $form->city->setValue($entity->getShipCity());
        $form->postal->setValue($entity->getShipPostal());
        
        $province = $entity->getShipProvince();
        if($province instanceof \Model\Entity\State){
            $form->state->setValue($province->getId());
        }
        
        $this->view->id_order = $entity->getId();
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\OrderHeader $entity
     * @param \Order_Form_AddressShip $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setShipStreet($form->getValue("address"));
        $entity->setShipCity($form->getValue("city"));
        $entity->setShipPostal($form->getValue("postal"));
        
        
        $province = App_Doctrine_Action_Find::primary("State", $form->getValue("state"));
        if($province instanceof \Model\Entity\State){
            $entity->setShipProvince($province);
        }
        
        
    }
    
    /**
     * 
     * @param Order_Form_AddressShip $form
     */
    protected function _setPostError($form){
        $this->view->id_order = $form->getValue("id");
    }
    
    /**
     * Retorna URl de retorno
     * @return string
     */
    protected function _redirectUrl(){
        return "/order/index/edit/id/" . $this->_getParam("id");
    }
    
    /**
     * Retorna la clase que arma el formulario
     * @return \Order_Form_AddressShip
     */
    protected function _getFormClass($parametros){
        $form = New Order_Form_AddressShip($parametros);
        $form->renderForm();
        return $form;
    }
}
?>
