<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Helper_Login extends Zend_Controller_Action_Helper_Abstract{
    
    /**
     * Nombre del model donde estan los usuarios
     * @var string
     */
    protected $_entity_name;
    
    /**
     * Nombre del campo del model, donde esta el nombre de usuario
     * @var string
     */
    protected $_identity_field;
    
    /**
     * Nombre del campo del model, donde esta la contraseña
     * @var string 
     */
    protected $_credential_field;
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $_entity_manager;
    
    /**
     * Datos del usuario recuperados del model
     * @var type 
     */
    private $_usuario;
    
    /**
     * Mensaje de salida para error
     * @var string
     */
    protected $_mensaje;
    
    /**
     * Url de retorno
     * @var string
     */
    protected $_request_url;
    
    /**
     * Constructor: inicializa el helper
     * 
     * @return void
     */
    public function __construct(){
        $this->_entity_manager = App_Doctrine_Repository::entityManager();
    }
    
    /**
     * Setea el nombre del modelo
     * @param string $entity_name
     */
    public function setEntity($entity_name){
        $this->_entity_name = $entity_name;
    }
    
    /**
     * Setea el nombre del campo del user
     * @param string $user_field
     */
    public function setUserField($user_field){
        $this->_identity_field = $user_field;
    }
    
    /**
     * Setea el nombre del campo para el password
     * @param string $pass_field
     */
    public function setPasswordField($pass_field){
        $this->_credential_field = $pass_field;
    }
    
    /**
     * Carga el index
     */
    public function index(){
        
        $request = $this->getRequest();
        $this->_mensaje = "";
    	if ($request->getParam('controller') != 'login') {
    	    $this->_request_url = $request->getRequestUri();
    	}
        
        
    }
    
    /**
     * Retorna el action
     * @return string
     */
    public function getAction(){
        $request = $this->getRequest();
        return "/" . $request->getModuleName() . "/" . $request->getControllerName() . "/process";
    }
    
    /**
     * Procesa el formulario de login
     * @return boolean
     */
    public function process(){
        
        $request = $this->getRequest();
	if (!$request->isPost()) {
            return false;
	}
        
        $user     = trim($request->getParam("username"));
        $password = trim($request->getParam("password"));
        $this->_request_url = $request->getParam("requesturl");
        
        if(strlen($user)==0 || strlen($password)==0){
           return $this->_setError("The user and password can't be empty");
        }
        
        $auth    = Zend_Auth::getInstance();
        $adapter = $this->_getAuthAdapter($user,$password);
	$result  = $auth->authenticate($adapter);
        
        if (!$result->isValid()) {

            $punto = "";
            $mensaje = "";
            foreach ($result->getMessages() as $message) {
                $mensaje .= $punto.$message;
                $punto = ". ";
            }
            
            return $this->_setError($mensaje);

	} else {
            // guardar los datos en sesion
            //$storage = $auth->getStorage();
            $user    = $adapter->getResultRowObject();
            $this->_usuario  = $user[0][0];
            //$storage->write(($entity->getId()));
            
            return true;
        }
    }
    
    /**
     * Retorna el usuario encontrado
     * @return \Model\Entity\xxxx
     */
    public function getUser(){
        return $this->_usuario;
    }
    
    /**
     * Guarda el usuario
     */
    public function writeStorage(){
        $auth    = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $storage->write(($this->_usuario->getId()));
    }
    
    /**
     * Retorna el mensaje
     * @return string
     */
    public function getMensaje(){
        return $this->_mensaje;
    }
    
    /**
     * Setea el mensaje
     * @param string $mensaje
     */
    public function setMensaje($mensaje){
        $this->_mensaje = $mensaje;
    }
    
    /**
     * 
     * @return string
     */
    public function getUrlRetorno(){
        if(strlen($this->_request_url) == 0){
           $this->_request_url = "/default/index";
        }
        return $this->_request_url;
    }
    
    /**
     * Devuelve el mensaje de error a vista
     * @param string $mensaje
     * @return boolean
     */
    protected function _setError($mensaje){
        $this->_mensaje = $mensaje;
        return false;
    }
    
    /**
     * Adaptador para realizar la coneccion con Zend_Auth
     * @param string $username
     * @param string $password
     * @return App_ZendX_Doctrine_Auth_Adapter 
     */
    protected function _getAuthAdapter($username, $password)
    {
        $authAdapter = new App_Doctrine_Auth_Adapter($this->_entity_manager);
        $encryptedPassword = sha1($password);
 
        $authAdapter->setEntityName($this->_entity_name)
            ->setIdentityField($this->_identity_field)
            ->setCredentialField($this->_credential_field)
            ->setIdentity($username)
            ->setCredential($encryptedPassword);
 
        return $authAdapter;
    }

}
?>
