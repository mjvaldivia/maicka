<?php

Class Zend_View_Helper_TableDetail extends App_Utilitario_Helpers{
    
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
    public function TableDetail($id_order){
        $this->_init();
        $this->_order = App_Doctrine_Action_Find::primary("OrderHeader", $id_order);
        
        $list = $this->_order->listOrderdetail();
        if(count($list)>0){
            $currency = New Zend_Currency();
            foreach($list as $order_detail){
                $this->_addHtml($this->view->partial("order-detail-item.phtml", 
                                                      array(
                                                            "id"     => $order_detail->getId(),
                                                            "id_order"  => $order_detail->getOrderHeader()->getId(),
                                                            "qty"    => $order_detail->getQuantity(),
                                                            "frame"  => $this->_getFrame($order_detail),
                                                            "word"   => $order_detail->getWord(),
                                                            "letter" => $this->_getLetterChoices($order_detail),
                                                            "price"  => $currency->toCurrency($order_detail->getPrice())
                                                           )
                                                    )
                               
                               );
            }
        }
        
        return $this->_getHtml();
    }
    
    /**
     * 
     * @param \Model\Entity\OrderDetail $order_detail
     */
    protected function _getLetterChoices(&$order_detail){
        return $order_detail->getLetterChoices();
    }
    
    /**
     * 
     * @param \Model\Entity\OrderDetail $order_detail
     */
    protected function _getFrame(&$order_detail){
        $frame = $order_detail->getFrame();
        if($frame instanceof \Model\Entity\Frame){
            return $frame->getName();
        }
        
        return "";
    }
}

?>
