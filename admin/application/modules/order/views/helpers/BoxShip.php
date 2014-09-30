<?php

Class Zend_View_Helper_BoxShip extends App_Utilitario_Helpers{
    
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
    public function BoxShip($id_order){
        $this->_init();
        $this->_order = App_Doctrine_Action_Find::primary("OrderHeader", $id_order);
        
        return $this->view->partial("order-box-ship.phtml", array(
                                                                  "id" => $id_order,
                                                                  "id_order" => $this->_order->getId(),
                                                                  "address1" => $this->_getAddress1(),
                                                                  "address2" => $this->_getAddress2(),
                                                                 )
                                   );
    }
    
 
    
    /**
     * 
     * @return string
     */
    protected function _getAddress2(){
        
        $salida = "";
        
        $province_name = "";
        $province = $this->_order->getShipProvince();
        if($province instanceof \Model\Entity\State){
            $province_name = $province->getName();
            $salida .= $province_name;
        }
        
        if($province_name!="" && $this->_order->getShipPostal()!=""){
            $salida .= ", ";
        }
        
        if($this->_order->getShipPostal()!=""){
            $salida .= $this->_order->getShipPostal();
        }
        
        return $salida;
    }
    
    /**
     * 
     * @return string
     */
    protected function _getAddress1(){
        $salida = "";
        
        if($this->_order->getShipStreet() != ""){
            $salida .= $this->_order->getShipStreet();
        }
        
        if($this->_order->getShipStreet() != "" && $this->_order->getShipCity() != ""){
            $salida .= ", ";
        }
        
        if($this->_order->getShipCity() != ""){
            $salida .= $this->_order->getShipCity();
        }
        
        return $salida;
    }
    
}

