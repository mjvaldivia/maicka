<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Order_IndexController extends Zend_Controller_Action{
    
    /**
     *
     * @var \Model\Entity\OrderHeader 
     */
    protected $_order;
    
    public function init() {
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/order/library/Action/Helpers', 'Helper');
    }
        
    /**
     * Index
     */
    public function indexAction() {
        $form = new Order_Form_OrderSearch(array('name' => "search_orders"));
        $form->renderForm();
        $this->view->form = $form;
    }
    
    /**
     * 
     * @return type
     */
    public function newAction(){
        $entity_manager = App_Doctrine_Repository::entityManager();
        $this->_order = New \Model\Entity\OrderHeader();
        
        $this->_order->setOrderDate(New DateTime("now"));
        $this->_order->setStatus(App_Doctrine_Action_Find::primary("OrderStatus", 1));
        
        $entity_manager->persist($this->_order);
        $entity_manager->flush();
        return $this->_redirect("/order/index/edit/id/" . $this->_order->getId());
    }
    
    /**
     * Editar
     */
    public function editAction(){
        $this->view->headScript()->appendFile('/js/demo/order.js', 'text/javascript');
        
        $this->_setOrder($this->_getParam("id"));
        
        $this->view->order_date = $this->_order->getOrderDate()->format("d/m/Y");
        $this->view->id_order = $this->_order->getId();
    }
    
    /**
     * Genera el pdf
     */
    public function pdfAction(){
        $this->_helper->Pdf->open($this->_getParam("id"));
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
?>
