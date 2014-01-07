<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Associated_Email_Actions_Save extends App_Module_Entities_Manager_Associated_Email_Actions_Abstract{
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
    protected $_emailForm = "";
    
    /**
     * Variables pasadas por parametro
     * @var Zend_Controller_Front::getInstance()->getRequest();
     */
    protected $_request;
    
    /**
     * Datos del formulario
     * @var array 
     */
    protected $_emailParams;
    
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
    public function isValid(){
        $emailCode = $this->_request->getParam("entity_email_code");
        foreach($emailCode as $key => $code){
            $form = $this->_getForm();
            $form->setCode($code);
            
            $delete = $this->_request->getParam("entity_email_delete_" . $code);
            if($delete) $form->setDelete(1);
            
            $form->createExistingElement();
            
            // parche para el valor multiple
            $this->_request->setParam("entity_email_code", $code);
            $this->_emailParams = array();
            if(!$form->isValid($this->_request->getParams())){
                if($delete!=1){ 
                    $error = true;
                    if(!$this->_validar){
                        $error = false;
                        $valores = $form->getValues();
                        $omitir = array("div_address", 
                                        "entity_email_code",
                                        "div_close_address",
                                        "entity_email_default_" . $code,
                                        "entity_email_id_" . $code);
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
                $this->_emailParams[$code] = $form->getValues();
            }
            
            
            $this->_emailForm .= $form; 
        }
        
        return $this->_valid;
        
    }
    
    /**
     * Guarda los emails
     */
    public function save(){
        $repository = App_Doctrine_Repository::repository("Email");
       
        foreach( $this->_emailParams as $code => $values){
           if($this->_delete($values, $code)){
               $id = $values['entity_email_id_' . $code]; 

               $email = $repository->find(array("id" => $id));
               if(!$email) $email = New \Model\Entity\Email();

               $email->setEmail($values['entity_email_address_' . $code]);
               
               $type = New Dtz_Model_EmailType($values['entity_email_type_' . $code]);
               
               $email->setType($type);
               $email->setDefault(true);
               $email->setEntity($this->_entity);

               if($values['entity_email_default_' . $code] == 1){
                 $email->setDefault(true);    
               } else $email->setDefault(false);

               $this->_entityManager->persist($email);
           }
        }
    }
    
     /**
     * Elimina los telefonos 
     * @param type $values
     * @param type $code
     * @return boolean 
     */
    protected function _delete($values, $code){
        $delete = $values['entity_email_delete_' . $code]; 
        if($delete){
         $repository = App_Doctrine_Repository::repository("Email");
         $email = $repository->find(array("id" => $values['entity_email_id_' . $code]));
         if($email) $this->_entityManager->remove($email);
         return false;
        } else return true;
    }
    
    /**
     * Devuelve el formulario
     * @return html
     */
    public function getForm(){
        return $this->_emailForm;
    }
}
?>
