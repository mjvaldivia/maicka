<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
abstract class App_Module_Entities_Manager_Controller extends App_Modulo_Mantenedor_Class {

    protected $_requestUrl;

    /**
     * @var Doctrine Manager
     */
    protected $_entityManager;

    /**
     * Si el formulario no tiene errores
     * @var Boolean 
     */
    protected $_valid = true;
    
    /**
     * Si se deben validar las direcciones
     * @var type 
     */
    protected $_validar_direcciones = true;
    
    /**
     * Si se deben validar los emails
     * @var type 
     */
    protected $_validar_emails = true;
    
    
    /**
     * Si se deben validar los telefonos
     * @var type 
     */
    protected $_validar_phone = true;

    /**
     * El tipo de entidad que se guardara
     * @var int 
     */
    protected $_entityType = 2;
    protected $_entity;
    protected $_modify = false;

    /**
     * Inicia ajax y agrega JS
     */
    public function init() {
        $this->_entityManager = App_Doctrine_Repository::entityManager();
        $this->view->headScript()->appendFile('/js/entity-manager.js', 'text/javascript');
        $this->view->redirect = $this->_requestUrl;
    }

    /**
     * Crea el formulario para MODIFICAR un entity
     */
    public function editAction() {

        $entity = $this->_setEntityByURL();
        $this->_loadAddressForm($entity);
        $this->_loadPhoneForm($entity);
        $this->_loadEmailForm($entity);
        $this->_loadNameForm($entity);
        $this->_loadSpecial($entity);
        $this->_loadProfile($entity);
        $this->render("new");
    }

    /**
     * Funcion para cargar datos especiales
     * @param type $entity 
     */
    protected function _loadSpecial($entity) {
        
    }

    /**
     * Setea la entity mediante el parametro ID enviado por URL o submit
     * @return type 
     */
    protected function _setEntityByURL() {
        $entityId = $this->_getParam("id");
        $entity = $this->_setEntity($entityId);
        $this->view->entityId = $entityId;
        return $entity;
    }

    /**
     * Crea el formulario para NUEVO entity
     */
    public function newAction() {
        $entity = $this->_setEntity();
        $this->_loadAddressForm($entity);
        $this->_loadPhoneForm($entity);
        $this->_loadEmailForm($entity);
        $this->_loadNameForm($entity);
        $this->_loadSpecial($entity);
        $this->_loadProfile($entity);
    }

    /**
     * Guarda el formulario
     */
    public function procesarAction() {
        $entityId = $this->_getParam("entity_id");
        $this->view->entityId = $entityId;
        $entity = $this-> _setEntity( $entityId);
        $this->_saveNameForm($entity);
        $this->_saveAddressForm($entity);
        $this->_savePhoneForm($entity);
        $this->_saveEmailForm($entity);
        $this->_saveTypeEntity($entity);
        $this->_saveSpecial($entity);
        /*print_r("Valido:" . $this->_valid);
        
        fb("Valido:" . $this->_valid);*/
        if (!$this->_valid) {
            $this->_noValido($entity);
            $this->view->activo = ($this->_getParam("active") == 1) ? "checked='checked'" : "";
            $this->view->value  = ($this->_getParam("active") == 1) ? 1 : "";
            $this->view->invalido = 1;
            return $this->render("new");
        } else {
            //$imageProcess = New Dtz_Upload_Process_Image($entity);
            //$imageProcess->modifyImage($this->_request->getParam("entity_image"));
            $this->_entityManager->flush();
            $this->_despuesSave($entity);
            $this->_entity = $entity;
            $this->view->invalido = 0;
            return $this->_redirect($this->_requestUrl);
        }
    }

    /**
     * Funcion que se ejecuta despues de efectuar el save
     * @param /Model/Entity/Entities $entity 
     */
    protected function _despuesSave($entity) {
        
    }

    /**
     * Se ejecuta despues de setear el formulario como no valido
     * @param /Model/Entity/Entities $entity
     */
    protected function _noValido($entity) {
        
    }

    /**
     * Carga el formulario de nombres
     * @param type $entity 
     */
    protected function _loadNameForm($entity) {
        $name = New App_Module_Entities_Manager_Entity_Actions_Name_Load();
        $name->setEntity($entity);
        $this->view->name = $name->getForm();
    }

    /**
     * Carga el formulario para email
     * @param type $entity 
     */
    protected function _loadEmailForm($entity) {
        $email = New App_Module_Entities_Manager_Associated_Email_Actions_Load();
        $email->setEntity($entity);
        $this->view->email = $email->getForm();
    }

    /**
     * Carga el formulario para phone
     * @param type $entity 
     */
    protected function _loadPhoneForm($entity) {
        $phone = New App_Module_Entities_Manager_Associated_Phone_Actions_Load();
        $phone->setEntity($entity);
        $this->view->phone = $phone->getForm();
    }
    
    /**
     * Carga el formulario para address
     * @param type $entity 
     */
    protected function _loadAddressForm($entity) {
        $address = New App_Module_Entities_Manager_Associated_Address_Actions_Load();
        $address->setEntity($entity);
        $this->view->address = $address->getForm();
    }

    /**
     * Guarda el formulario de nombre
     * @param type $entity 
     */
    protected function _saveNameForm($entity) {
        $name = New App_Module_Entities_Manager_Entity_Actions_Name_Save();
        $name->setEntity($entity);
        if ($name->isValid()) {
            $name->save();
        } else {
            $this->_valid = false;
        }
        $this->view->name = $name->getForm();
    }

    /**
     * Guarda el tipo de entidad
     * @param type $entity 
     */
    protected function _saveTypeEntity($entity) {
        $typeModel = App_Doctrine_Repository::repository("Entitytype");
        $entityTypeModel = App_Doctrine_Repository::repository("EntitiesEntitytype");

        $type = $typeModel->find($this->_entityType);
        if ($type) {
            $entityType = $entityTypeModel->findOneBy(array("entities" => $entity->getId(), "entitytype" => $type->getId()));
            if (!$entityType) {
                $entityType = New \Model\Entity\EntitiesEntitytype;
            }
            $entityType->setActive(true);
            $entityType->setEntity($entity);
            $entityType->setType($type);

            $this->_entityManager->persist($entityType);
        } else
            throw new exception("The user type don't exist");
    }

    /**
     * Guarda el formulario de telefono
     * @param type $entity 
     */
    protected function _savePhoneForm($entity) {
        $phone = New App_Module_Entities_Manager_Associated_Phone_Actions_Save($this->_validar_phone);
        $phone->setEntity($entity);
        if ($phone->isValid()) {
            $phone->save();
        } else {
            $this->_valid = false;
        }
        $this->view->phone = $phone->getForm();
    }

    /**
     * Guarda el formulario de email
     * @param type $entity 
     */
    protected function _saveEmailForm($entity) {
        $email = New App_Module_Entities_Manager_Associated_Email_Actions_Save($this->_validar_emails);
        $email->setEntity($entity);
        if ($email->isValid()) {
            $email->save();
        } else {
            $this->_valid = false;
        }
        $this->view->email = $email->getForm();
    }

    /**
     * Guarda el formulario de address
     * @param type $entity 
     */
    protected function _saveAddressForm($entity) {
        $address = New App_Module_Entities_Manager_Associated_Address_Actions_Save($this->_validar_direcciones);
        $address->setEntity($entity);
        if ($address->isValid()) {
            $address->save();
        } else {
            $this->_valid = false;
        }
        $this->view->address = $address->getForm();
    }

    /**
     * Crea la variable $entity con el model Entities para modificar 
     * @param type $entityId
     * @return /Model/Entity/Entities 
     */
    protected function _setEntity($entityId = NULL) {
        $entityClass = New App_Module_Entities_Manager_Entity_Actions_Entities();
        $entityClass->setEntity($entityId);
        $entity = $entityClass->getEntity();
        $this->_entity = $entity;
        $this->_modify = $entityClass->isModify();
        return $entity;
    }

    /**
     * Sobreescribir con datos especiales
     * @param /Model/Entity/Entities $entity 
     */
    protected function _saveSpecial($entity) {
        
    }
    
}

?>
