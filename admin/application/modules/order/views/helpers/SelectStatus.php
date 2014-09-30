<?php
Class Zend_View_Helper_SelectStatus extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    
    /**
     *
     * @var \Model\Entity\OrderHeader 
     */
    protected $_order;
    
    /**
     * Genera caja de direccion bill de la orden
     * @param int $id_order
     */
    public function SelectStatus($id_order){
        $this->_init();
        $this->_order = App_Doctrine_Action_Find::primary("OrderHeader", $id_order);
        
        $select = New Zend_Form_Element_Select("order_status");
        $select->clearDecorators();
        $select->addDecorator("viewHelper");
        
        $list = App_Doctrine_Action_Query::fetchAll("OrderStatus", "findAll");
        $select->addMultiOptions(App_Utilitario_Form_Select::setFormatMethod($list, "getId", "getName"));
 
        
        
        $status = $this->_order->getStatus();
        if($status instanceof \Model\Entity\OrderStatus){
            $select->setValue($status->getId());
        }
        
        
        return $select;
    }
}

