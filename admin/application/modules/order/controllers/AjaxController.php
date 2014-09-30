<?php

class Order_AjaxController extends Zend_Controller_Action{
    
     /**
     * Actions llamados por ajax
     * @var array 
     */
    public $ajaxable = array("change-status" => array("json"));
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_entity_manager;
    
    /**
     *
     * @var \Model\Entity\OrderHeader 
     */
    protected $_order;
    
    /**
     * init
     */
    public function init() {
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/order/library/Action/Helpers', 'Helper');
        $this ->_helper->getHelper('AjaxContext')->initContext();
        $this->_entity_manager = App_Doctrine_Repository::entityManager();
        
        $this->_setOrder($this->_getParam("id"));
    }
    
    /**
     * Cambia el Status de la orden
     */
    public function changeStatusAction(){
        $status = App_Doctrine_Action_Find::primary("OrderStatus", $this->_getParam("status"));
        if($status instanceof \Model\Entity\OrderStatus){
            $this->_order->setStatus($status);
            
            $this->_entity_manager->persist($this->_order);
            $this->_entity_manager->flush();
        }
    }
    
    /**
     * Setea la orden
     * @param int $id_order
     * @throws Exception
     */
    protected function _setOrder($id_order){
        $this->_order = App_Doctrine_Action_Find::primary("OrderHeader", $id_order);
        if(!($this->_order instanceof \Model\Entity\OrderHeader)){
            throw new Exception("The order don't exist");
        }
    }
}

