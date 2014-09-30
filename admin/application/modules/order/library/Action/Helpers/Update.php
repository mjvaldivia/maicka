<?php

class Helper_Update extends Zend_Controller_Action_Helper_Abstract{
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_entity_manager;
    
    /**
     *
     * @var \Model\Entity\OrderHeader 
     */
    protected $_order;
    
    public function __construct() {
        $this->_entity_manager = App_Doctrine_Repository::entityManager();
    }
    
    /**
     * Actualiza los totales de la orden
     */
    public function totales($id_order){
        $this->_setOrder($id_order);
        
        $list_detail = $this->_order->listOrderdetail();
        if(count($list_detail)>0){
            $subtotal = 0;
            foreach($list_detail as $order_detail){
                $subtotal += $order_detail->getPrice();
            }
            
            $this->_order->setSubtotal($subtotal);
            $this->_order->setTax($this->_getTax($subtotal));
            $this->_order->setShipping($this->_getShipping());
            
            $this->_order->setTotal($this->_order->getSubtotal() + $this->_order->getTax() + $this->_order->getShipping());
        }
        
        $this->_entity_manager->persist($this->_order);
        $this->_entity_manager->flush();
    }
    
    /**
     * Funcion para calcular el tax
     * @param int $subtotal
     * @return float
     */
    protected function _getTax($subtotal){
        return 0;
    }
    
    /**
     * Devuelve el valor de shipping
     * @return float
     */
    protected function _getShipping(){
        $province = $this->_order->getShipProvince();
        if($province instanceof \Model\Entity\State){
           $country = $province->getCountry(); 
           
           $repository = App_Doctrine_Repository::repository("Shipping");
           $shipping = $repository->findOneBy(array("country" => $country->getId()));
           if($shipping instanceof \Model\Entity\Shipping){
               return $shipping->getPrice();
           }
        }
        
        return 0;
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

