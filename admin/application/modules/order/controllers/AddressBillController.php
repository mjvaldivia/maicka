<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Order_AddressBillController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "OrderHeader";
        
    /**
     * 
     * @param \Order_Form_AddressBill $form
     * @param \Model\Entity\OrderHeader $entity
     */
    protected function _setEdit(&$form, $entity){
        
        $customer = $entity->getClient();
        if($customer instanceof \Model\Entity\Entities){
           $form->customer->setValue($customer->getId());
        }
        
        $form->address->setValue($entity->getBillStreet());
        $form->city->setValue($entity->getBillCity());
        $form->postal->setValue($entity->getBillPostal());
        
        $province = $entity->getBillProvince();
        if($province instanceof \Model\Entity\State){
            $form->state->setValue($province->getId());
        }
        
        $this->view->id_order = $entity->getId();
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\OrderHeader $entity
     * @param \Order_Form_AddressBill $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setBillStreet($form->getValue("address"));
        $entity->setBillCity($form->getValue("city"));
        $entity->setBillPostal($form->getValue("postal"));
        
        $customer = App_Doctrine_Action_Find::primary("Entities", $form->getValue("customer"));
        if($customer instanceof \Model\Entity\Entities){
            $entity->setClient($customer);
        }
        
        $province = App_Doctrine_Action_Find::primary("State", $form->getValue("state"));
        if($province instanceof \Model\Entity\State){
            $entity->setBillProvince($province);
        }
        
        
    }
    
    /**
     * 
     * @param Order_Form_AddressBill $form
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
     * @return \Order_Form_AddressBill
     */
    protected function _getFormClass($parametros){
        $form = New Order_Form_AddressBill($parametros);
        $form->renderForm();
        return $form;
    }
}
?>
