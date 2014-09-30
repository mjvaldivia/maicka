<?php

/**
 * Calcula la latitud y longitus de una direccion dada
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 * 
 * @example $location = New App_Module_Google_Maps_LatitudLongitud();
            $location->setStreet("Alfa centauri 886");
            $location->setCity("Villa Alemana");
            $location->setState("Valparaiso");
            $location->setCountry("Chile");
            $location->calculate();
        
            echo $location->getLat()." ".$location->getLon(); 
 */
class Vendor_Google_Maps_LatitudLongitud extends Vendor_Google_Abstract{
    
    /**
     * Calle
     * @var string 
     */
    protected $_street;
    
    /**
     * ciudad
     * @var string 
     */
    protected $_city;
    
    /**
     * Provincia o estado
     * @var string 
     */
    protected $_state;
    
    /**
     * Pais
     * @var string 
     */
    protected $_country;
    
    /**
     * Filtra y formatea un string para que sea interpretado por google
     * @var Zend_Filter_PregReplace
     */
    protected $_filter;
    
    /**
     * Latitud de la direccion
     * @var float 
     */
    protected $_lat;
    
    /**
     * Longitud de la direccion
     * @var float 
     */
    protected $_lon;
    
    /**
     * Calcula la latitud y longitud de una direccion
     */
    public function __construct() {
        parent::__construct();
        $this->_filter = New Zend_Filter_PregReplace(array('match' => '/[ ]+/',
                                                           'replace' => '+'));
    }
    
    /**
     * Setea la calle y numero
     * @param string $street 
     */
    public function setStreet($street){
        $this->_street = $this->_filter->filter($street);
    }
    
    /**
     * Setea la ciudad
     * @param string $city 
     */
    public function setCity($city){
        $this->_city = $this->_filter->filter($city);
    }
    
    /**
     * Setea la provincia o estado
     * @param string $state 
     */
    public function setState($state){
        $this->_state = $this->_filter->filter($state);
    }
    
    /**
     * Setea el pais
     * @param string $country 
     */
    public function setCountry($country){
        $this->_country = $this->_filter->filter($country);
    }
    
    /**
     * Recupera la latitud
     * @return float 
     */
    public function getLat(){
        return $this->_lat;
    }
    
    /**
     * Recupera la longitud
     * @return float 
     */
    public function getLon(){
        return $this->_lon;
    }
    
    /**
     * Ejecuta el calculo de la latitud y longitud
     */
    public function calculate(){
        $zfClient = new Zend_Http_Client($this->_config->google->url->geolocation);        
        $zfClient->setConfig(array(
          'timeout' => 45
        ));
        
        $zfClient->setMethod(Zend_Http_Client::GET);
        $zfClient->setParameterGet(array("address" => $this->_generateAddress(), "sensor" => "false"));
        $resp = $zfClient->request()->getBody();
        
        return $this->_decodificar($resp);
    }
    
    /**
     * Decodifica la respuesta de google
     * @param json $geocode 
     */
    protected function _decodificar($geocode){
        $output = \Zend_Json_Decoder::decode($geocode);

        if(count($output["results"])>0){
            $lat =  $output["results"][0]["geometry"]["location"]["lat"];
            $long = $output["results"][0]["geometry"]["location"]["lng"];

            $this->_lat = $lat;
            $this->_lon = $long;
            return true;
        } else return false;
    }
    
    /**
     * Genera la cadena de string para la direccion
     * @return string 
     */
    protected function _generateAddress(){
           $address = $this->_street . ","
                     .$this->_city . ","
                     .$this->_state . ","
                     .$this->_country;
           return $address;
    }
}
?>
