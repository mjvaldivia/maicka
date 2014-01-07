<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Associated_Address_Actions_Save extends App_Module_Entities_Manager_Associated_Address_Actions_Abstract {

    /**
     * Si el formulario es valido
     * @var Boolean 
     */
    protected $_valid = true;
    
    /**
     * Si el formulario sera validado o no
     */
    protected $_validar;

    /**
     * Contiene el html del formulario
     * @var html 
     */
    protected $_addressForm = "";

    /**
     * Variables pasadas por parametro
     * @var Zend_Controller_Front::getInstance()->getRequest();
     */
    protected $_request;

    /**
     * Datos del formulario
     * @var array 
     */
    protected $_addressParams;

    /**
     * 
     * @var Doctrine 
     */
    protected $_entityManager;

    /**
     * Constructor
     */
    public function __construct($validar = true) {
        parent::__construct();
        $this->_validar = $validar;
        $this->_request = Zend_Controller_Front::getInstance()->getRequest();
        $this->_entityManager = App_Doctrine_Repository::entityManager();
    }

    /**
     * Verifica que el formulario sea valido
     * @return boolean 
     */
    public function isValid() {
        $addressCode = $this->_request->getParam("entity_address_code");
        foreach ($addressCode as $key => $code) {
            $form = $this->_getForm();
            $form->setCode($code);

            $delete = $this->_request->getParam("entity_address_delete_" . $code);
            if ($delete)
                $form->setDelete(1);

            $form->createExistingElement();

            // parche para el valor multiple
            $this->_request->setParam("entity_address_code", $code);


            $province = "entity_address_province_" . $code;
            $form->{$province}->addMultiOptions($this->_getProvinceCombo($this->_request->getParam("entity_address_country_" . $code)));

            
            if (!$form->isValid($this->_request->getParams())) {
                if ($delete != 1) {
                    $error = true;
                    if(!$this->_validar){
                        $error = false;
                        $valores = $form->getValues();
                        $omitir = array("div_address", 
                                        "entity_address_code",
                                        "div_close_address",
                                        "entity_address_default_" . $code,
                                        "entity_address_id_" . $code);
                        foreach($valores as $input => $valor){
                            if(!in_array($input, $omitir)){
                                $valor = trim((string) $valor);
                                if(strlen($valor)>0 and $valor!="0"){
                                   $error = true; 
                                }
                            }
                        }
                    }
                    
                    if($error){
                        $form->processErrors();
                        $this->_valid = false;
                    }
                }
            } else {
                $this->_addressParams[$code] = $form->getValues();
            }

            $this->_addressForm .= $form;
        }

        return $this->_valid;
    }

    /**
     * Guarda los emails
     */
    public function save() {

        $repository = App_Doctrine_Repository::repository("Address");
        if(count($this->_addressParams)>0){
            foreach ($this->_addressParams as $code => $values) {

                if ($this->_delete($values, $code)) {

                    $id = $values['entity_address_id_' . $code];

                    $address = $repository->find(array("id" => $id));
                    if (!$address)
                        $address = New \Model\Entity\Address();

                    if ($values['entity_address_street_' . $code]) {
                        $address->setEntity($this->_entity);
                        $address->setStreet($values['entity_address_street_' . $code]);
                        $address->setCity($values['entity_address_city_' . $code]);
                        $address->setState($this->_getState($values['entity_address_province_' . $code]));
                        $address->setPostal($values['entity_address_postal_' . $code]);

                        $type = New Dtz_Model_AddressType($values['entity_address_type_' . $code]);
                        $address->setType($type);

                        if ($values['entity_address_default_' . $code] == 1) {
                            $address->setDefault(true);
                            if ($values['entity_address_country_' . $code] != "") {
                                if ($values['entity_address_country_' . $code] > 1) {

                                    $entityMaster = $this->_entity;
                                    if ($values['entity_address_country_' . $code] == '1')
                                        $curren = '1';
                                    else
                                        $curren = '2';

                                   /* $currencyModel = App_Doctrine_Repository::repository("Currency");
                                    $carrency = $currencyModel->find($curren);                                
                                    $entityMaster->setCurrency($carrency);*/
                                    $this->_entityManager->persist($entityMaster);
                                }
                            }
                        } else
                            $address->setDefault(false);


                       // $address->setLocation();


                        $this->_entityManager->persist($address);
                    }
                }
            }
        }
    }

    /**
     * Elimina los telefonos 
     * @param type $values
     * @param type $code
     * @return boolean 
     */
    protected function _delete($values, $code) {
        $delete = $values['entity_address_delete_' . $code];
        if ($delete) {
            $repository = App_Doctrine_Repository::repository("Address");
            $address = $repository->find(array("id" => $values['entity_address_id_' . $code]));
            if ($address)
                $this->_entityManager->remove($address);
            return false;
        } else
            return true;
    }

    /**
     * Devuelve el formulario
     * @return html
     */
    public function getForm() {
        return $this->_addressForm;
    }

    /**
     * Recupera el estado/provincia
     * @param integer $state
     * @return /Model/Entity/Stateprov 
     */
    protected function _getState($state) {
        $stateRepository = App_Doctrine_Repository::repository("Stateprov");
        $state = $stateRepository->find(array("id" => $state));
        return $state;
    }

}

?>
