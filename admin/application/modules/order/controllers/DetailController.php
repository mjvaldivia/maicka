<?php

class Order_DetailController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "OrderDetail";
        
    public function init() {
        parent::init();
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/order/library/Action/Helpers', 'Helper');
    }
        
     /**
     * 
     * @param \Order_Form_Detail $form
     */
    protected function _setNew(&$form){
        $form->order->setValue($this->_getParam("order"));
        $this->view->id_order = $this->_getParam("order");
    }
    
        /**
     * Setea campos especiales
     * @param \Model\Entity\OrderDetail $entity
     * @param \Order_Form_Detail $form
     */
    protected function _setPostProcess(&$entity, $form){        
        $this->_helper->Update->totales($entity->getOrderHeader()->getId());
    }
    
    
    /**
     * 
     * @param \Order_Form_Detail $form
     * @param \Model\Entity\OrderDetail $entity
     */
    protected function _setEdit(&$form, $entity){
        $form->quantity->setValue($entity->getQuantity());
        $form->word->setValue($entity->getWord());
        $form->letters->setValue($entity->getLetterChoices());
        $form->price->setValue($entity->getPrice());
        
        $frame = $entity->getFrame();
        if($frame instanceof \Model\Entity\Frame){
            $form->frame->setValue($frame->getId());
        }
        
        $form->order->setValue($entity->getOrderHeader()->getId());
        
        $this->view->id_order = $entity->getOrderHeader()->getId();
        
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\OrderDetail $entity
     * @param \Order_Form_Detail $form
     */
    protected function _setProcess(&$entity, $form){
        
        $entity->setQuantity($form->getValue("quantity"));
        $entity->setWord($form->getValue("word"));
        $entity->setLetterChoices($form->getValue("letters"));
        $entity->setPrice($form->getValue("price"));
        
        $frame = App_Doctrine_Action_Find::primary("Frame", $form->getValue("frame"));
        if($frame instanceof \Model\Entity\Frame){
            $entity->setFrame($frame);
        }
        
        $order = App_Doctrine_Action_Find::primary("OrderHeader", $form->getValue("order"));
        if($order instanceof \Model\Entity\OrderHeader){
            $entity->setOrderHeader($order);
        } else {
            throw new Exception("The order don't exist");
        }
    }
    
    /**
     * 
     * @param Order_Form_Detail $form
     */
    protected function _setPostError($form){
        $this->view->id_order = $form->getValue("order");
    }
    
    /**
     * Retorna URl de retorno
     * @return string
     */
    protected function _redirectUrl(){
        return "/order/index/edit/id/" . $this->_getParam("order");
    }
    
    /**
     * Retorna la clase que arma el formulario
     * @return \Order_Form_Detail
     */
    protected function _getFormClass($parametros){
        $form = New Order_Form_Detail($parametros);
        $form->renderForm();
        return $form;
    }
    

}

