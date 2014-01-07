<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Ordenes_Viajeros extends App_Utilitario_Helpers{
    
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
     * Muestra el detalle de los viajeros
     * @param integer $order_id
     */
    public function Ordenes_Viajeros($orden_id){
        $this->_init();
        $this->_setOrden($orden_id);
        
        $list = $this->_listViajeros();
        foreach($list as $viajero){
            $fecha = "";
            $fecha_nacimiento = $viajero->getFechaNacimiento();
            if($fecha_nacimiento instanceof DateTime){
                $fecha = $fecha_nacimiento->format("Y-m-d");
            }
            
            $this->_addHtml($this->view->partial("viajeros-orden.phtml", array("rut" => $viajero->getRut(),
                                                                               "nombre" => $this->_getNombre($viajero),
                                                                               "sexo" => "",
                                                                               "edad" => $viajero->getEdad(),
                                                                               "fecha_nacimiento" => $fecha,
                                                                               "email" => $viajero->getEmail(),
                                                                               "telefono" => $this->_getTelefono($viajero),
                                                                      
                                                                               "direccion" => $viajero->getDireccion(),
                                                                               "ciudad" => $viajero->getCiudad(),
                                                                               "comuna" => $viajero->getComuna(),
                                                                               "emergencia_nombre" => $this->_getNombreEmergencia($viajero),
                                                                               "emergencia_telefono" => $viajero->getEmTelefono()
                                                                              )
                                                )
                           );
        }
        
        return $this->_getHtml();
    }
    
    /**
     * 
     * @param \Model\Entity\OrdenPasajero $viajero
     */
    protected function _getTelefono($viajero){
        $telefono = $viajero->getTelefono();
        return $telefono;
    }
    
    /**
     * 
     * @param \Model\Entity\OrdenPasajero $viajero
     */
    protected function _getNombre($viajero){
        $nombre = $viajero->getName() . " " . $viajero->getApellidoPaterno() . " " . $viajero->getApellidoMaterno();
        return $nombre;
    }
    
    /**
     * 
     * @param \Model\Entity\OrdenPasajero $viajero
     */
    protected function _getNombreEmergencia($viajero){
        $nombre = $viajero->getEmNombre() . " " . $viajero->getEmApellido();
        return $nombre;
    }
    
    /**
     * Recupera la orden
     * @param integer $orden_id
     */
    protected function _setOrden($orden_id){
        $this->_orden = App_Doctrine_Action_Find::primary("Orden", $orden_id);
    }
    
    /**
     * 
     * @return array \Model\Entity\OrdenPasajero
     */
    protected function _listViajeros(){
        $list = $this->_orden->listPasajeros();
        return $list;
    }
}
?>
