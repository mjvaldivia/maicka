<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Associated_Phone_Actions_Save extends App_Module_Entities_Manager_Associated_Phone_Actions_Abstract {

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
    protected $_phoneForm = "";

    /**
     * Variables pasadas por parametro
     * @var Zend_Controller_Front::getInstance()->getRequest();
     */
    protected $_request;

    /**
     * Datos del formulario
     * @var array 
     */
    protected $_phoneParams;

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
        $phoneCode = $this->_request->getParam("entity_phone_code");
        foreach ($phoneCode as $key => $code) {
            $form = $this->_getForm();
            $form->setCode($code);

            $delete = $this->_request->getParam("entity_phone_delete_" . $code);
            if ($delete)
                $form->setDelete(1);

            $form->createExistingElement();

            // parche para el valor multiple
            $this->_request->setParam("entity_phone_code", $code);
            $this->_phoneParams = array();
            if (!$form->isValid($this->_request->getParams())) {
                if ($delete != 1) {
                    $error = true;
                    if(!$this->_validar){
                        $error = false;
                        $valores = $form->getValues();
                        $omitir = array("div_address", 
                                        "entity_phone_code",
                                        "div_close_address",
                                        "entity_phone_default_" . $code,
                                        "entity_phone_id_" . $code);
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
                $this->_phoneParams[$code] = $form->getValues();
            }

            $this->_phoneForm .= $form;
        }

        return $this->_valid;
    }

    /**
     * Guarda los telefonos
     */
    public function save() {
        $repository = App_Doctrine_Repository::repository("Phone");

        foreach ($this->_phoneParams as $code => $values) {
            if ($values['entity_phone_number_' . $code]!='') {
                if ($this->_delete($values, $code)) {
                    $id = $values['entity_phone_id_' . $code];

                    $phone = $repository->find(array("id" => $id));
                    if (!$phone)
                        $phone = New \Model\Entity\Phone();

                    $phone->setNumber($values['entity_phone_number_' . $code]);

                    $type = New Dtz_Model_PhoneType($values['entity_phone_type_' . $code]);
                    $phone->setType($type);
                    $phone->setDefault(true);
                    $phone->setEntity($this->_entity);

                    if ($values['entity_phone_default_' . $code] == 1) {
                        $phone->setDefault(true);
                    } else
                        $phone->setDefault(false);


                    $this->_entityManager->persist($phone);
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
        $delete = $values['entity_phone_delete_' . $code];
        if ($delete) {
            $repository = App_Doctrine_Repository::repository("Phone");
            $phone = $repository->find(array("id" => $values['entity_phone_id_' . $code]));
            if ($phone)
                $this->_entityManager->remove($phone);
            return false;
        } else
            return true;
    }

    /**
     * Devuelve el formulario
     * @return html
     */
    public function getForm() {
        return $this->_phoneForm;
    }

}

?>
