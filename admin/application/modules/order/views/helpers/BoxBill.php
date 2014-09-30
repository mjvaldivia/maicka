<?php

Class Zend_View_Helper_BoxBill extends App_Utilitario_Helpers{
    
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
    public function BoxBill($id_order){
        $this->_init();
        $this->_order = App_Doctrine_Action_Find::primary("OrderHeader", $id_order);
        
        return $this->view->partial("order-box-bill.phtml", array(
                                                                  "id" => $id_order,
                                                                  "id_order" => $this->_order->getId(),
                                                                  "name" => $this->_getClientName(),
                                                                  "address1" => $this->_getAddress1(),
                                                                  "address2" => $this->_getAddress2(),
                                                                  "phone" => $this->_getPhone(),
                                                                  "email" => $this->_getEmail()
                                                                 )
                                   );
    }
    
    /**
     * 
     * @return string
     */
    protected function _getEmail(){
        $client = $this->_order->getClient();
        if($client instanceof \Model\Entity\Entities){
            $email = $client->getDefaultEmail();
            if($email instanceof \Model\Entity\Email){
                return $email->getEmail();
            }
        }
        
        return "<span class=\"text-red\">No email</span>";
    }
    
    /**
     * 
     * @return string
     */
    protected function _getPhone(){
        $client = $this->_order->getClient();
        if($client instanceof \Model\Entity\Entities){
            $phone = $client->getDefaultPhone();
            if($phone instanceof \Model\Entity\Phone){
                return $phone->getNumber();
            }
        }
        
        return "<span class=\"text-red\">No phone</span>";
    }
    
    /**
     * 
     * @return string
     */
    protected function _getAddress2(){
        
        $salida = "";
        
        $province_name = "";
        $province = $this->_order->getBillProvince();
        if($province instanceof \Model\Entity\State){
            $province_name = $province->getName();
            $salida .= $province_name;
        }
        
        if($province_name!="" && $this->_order->getBillPostal()!=""){
            $salida .= ", ";
        }
        
        if($this->_order->getBillPostal()!=""){
            $salida .= $this->_order->getBillPostal();
        }
        
        return $salida;
    }
    
    /**
     * 
     * @return string
     */
    protected function _getAddress1(){
        $salida = "";
        
        if($this->_order->getBillStreet() != ""){
            $salida .= $this->_order->getBillStreet();
        }
        
        if($this->_order->getBillStreet() != "" && $this->_order->getBillCity() != ""){
            $salida .= ", ";
        }
        
        if($this->_order->getBillCity() != ""){
            $salida .= $this->_order->getBillCity();
        }
        
        return $salida;
    }
    
    /**
     * 
     * @return string
     */
    protected function _getClientName(){
        $client = $this->_order->getClient();
        if($client instanceof \Model\Entity\Entities){
            return $client->getName();
        }
        
        return "<span class=\"text-red\"> No Client Assigned</span>";
    }
}

