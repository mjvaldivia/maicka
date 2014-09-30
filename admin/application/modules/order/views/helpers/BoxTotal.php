<?php

Class Zend_View_Helper_BoxTotal extends App_Utilitario_Helpers{
    
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
     * 
     * @param int $id_order
     */
    public function BoxTotal($id_order){
        $this->_init();
        $this->_order = App_Doctrine_Action_Find::primary("OrderHeader", $id_order);
        
        
        $currency = New Zend_Currency();
        return $this->view->partial("order-box-total.phtml", 
                                    array(
                                          "net" => $currency->toCurrency($this->_order->getSubtotal()),
                                          "tax" => $currency->toCurrency($this->_order->getTax()),
                                          "shipping" => $currency->toCurrency($this->_order->getShipping()),
                                          "total" => $currency->toCurrency($this->_order->getTotal()),
                                         )
                                   );
    }
}

