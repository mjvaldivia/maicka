<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Ordenes_Ver extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     *
     * @var \Model\Entity\Orden 
     */
    protected $_orden;
    
    /**
     * Muestra el detalle de la orden
     * @param integer $orden_id
     * @return string html
     */
    public function Ordenes_Ver($orden_id){
        $this->_init();
        $this->_setOrden($orden_id);
        if ($this->_orden->getStatus())
            $status_orden = $this->_orden->getStatus()->getName();
        else {
            $status_orden = "Ingresada";
        }
        
        $pago = $this->_orden->getPago();
        if ($pago){
            $fecha_pago = App_Formato_fecha::formato("d/m/Y",$pago->getFechaPago());
            $monto_pago = $pago->getMonto();
            $metodo     = $pago->getName();
        } else {
            $fecha_pago = "";
            $monto_pago = 0;
            $metodo = "";
        }
        
        $tipo_descuento_nombre = "Sin descuento";
        $tipo_descuento = $this->_orden->getTipoDescuento();
        if($tipo_descuento instanceof \Model\Entity\TipoDescuento){
            $tipo_descuento_nombre = $tipo_descuento->getName();
        }
        
        $currency = New Zend_Currency();
        $currency->setFormat(array("precision" => 0));
        return $this->view->partial("ver-orden.phtml", array("id" => $this->_orden->getId(),
                                                             "fecha_salida" => App_Formato_fecha::formato("d/m/Y",$this->_orden->getSalida()),
                                                             "fecha_regreso" => App_Formato_fecha::formato("d/m/Y",$this->_orden->getRegreso()),
                                                             "destino" => $this->_getDestino(),
                                                             "cantidad" => $this->_getCantidadPasajeros(),
                                                             "plan" => $this->_getNombrePlan(),
                                                             "proveedor" => $this->_getNombreProveedor(),
                                                             "motivo" => $this->_getMotivo(),
                                                             "total" => $currency->toCurrency($this->_orden->getTotal()),
                                                             "subtotal" => $currency->toCurrency($this->_orden->getSubtotal()),
                                                             "descuento" => $currency->toCurrency($this->_orden->getDescuento()),
                                                             "tipo_descuento" => $tipo_descuento_nombre,
                                                             "fecha_orden" => App_Formato_fecha::formato("d/m/Y",$this->_orden->getFechaOrden()),
                                                             "status_orden" => $status_orden,
                                                             "pago" => $currency->toCurrency($monto_pago),
                                                             "fecha_pago" => $fecha_pago,
                                                             "metodo_pago" => $metodo)                                                            
                                   );
    }
    
    /**
     * Recupera la orden
     * @param integer $orden_id
     */
    protected function _setOrden($orden_id){
        $this->_orden = App_Doctrine_Action_Find::primary("Orden", $orden_id);
        
    }
    
    /**
     * Recupera el motivo
     * @return string
     */
    protected function _getMotivo(){
        $motivo = $this->_orden->getMotivo();
        if($motivo){
            return $motivo->getName();
        }
    }
    
    /**
     * recupera el nombre del plan
     * @return string
     */
    protected function _getNombrePlan(){
        $plan = $this->_orden->getPlan();
        if($plan){
            return $plan->getName();
        }
    }
    
    /**
     * Recupera el nombre del proveedor
     * @return type
     */
    protected function _getNombreProveedor(){
        $proveedor = $this->_orden->getNombreProveedor();
        return $proveedor;
    }
    
    /**
     * Recupera la cantidad de pasajeros
     * @return integer
     */
    protected function _getCantidadPasajeros(){
        $pasajeros_model  = App_Doctrine_Repository::repository("OrdenPasajero");
        return $pasajeros_model->getPasajerosPorOrden($this->_orden->getId());
    }
    
    /**
     * Lista los paises destino
     * @return string
     */
    protected function _getDestino(){
        $destinos                = $this->_orden->listDestino();
        $paises                = "";
        foreach ($destinos as $paisDestinos){
            $paises .= $paisDestinos->getName()."<br/>";
        }
        return $paises;
    }
}
?>
