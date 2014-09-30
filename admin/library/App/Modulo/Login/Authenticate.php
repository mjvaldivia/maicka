<?php

class App_Modulo_Login_Authenticate extends Zend_Controller_Plugin_Abstract{
    
    /**
     * Contiene la lista de controllers a los cuales no se les verifica
     * que el usuario este logeado
     * @var array 
     */
    protected $_controllersSinVerificacion = array("error");
    
    /**
     * Contiene la lista de controllers a los cuales no se les verifica
     * que el usuario este logeado
     * @var array 
     */
    protected $_moduleSinVerificacion = array("login");
        
     /**
     * Contiene el objeto Zend_Auth
     * 
     * @var Zend_Auth
     */
    protected $_auth;
 
    /**
     * Contiene el objeto Zend_Acl
     * 
     * @var Zend_Acl
     */
    protected $_acl;
 
    /**
     * El objeto de la clase singleton
     * 
     * @var Plugin_CheckAccess
     */
    static private $instance = NULL;
    
    
     /**
     * Constructor 
     */
     public function __construct()
    {
        $this->_auth =  Zend_Auth::getInstance();
      //  $this->_acl =   new App_User_Acl(APPLICATION_PATH."/configs/permissions.ini");
    }
    
      /**
     * Retorna el Rol del usuario actual
     * 
     * @return string
     */
    protected function _getRol()
    {
        if($this->_auth->hasIdentity()){
            $result = Zend_Registry::get('user');
            $entityName = $result->getName();
            return $entityName;
        } else return "Invitado";
        
    } 
     /**
     * Devuelve el objeto de la clase singleton
     * 
     * @return Plugin_CheckAccess
     */
    static public function getInstance() {
       if (self::$instance == NULL) {
          self::$instance = new App_Plugin_Authenticate();
       }
       return self::$instance;
    }
    
    /**
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return type 
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        
        if(array_search($request->getControllerName(), $this->_controllersSinVerificacion) === false AND 
           array_search($request->getModuleName(), $this->_moduleSinVerificacion) === false){
            
            if (!$this->_auth->hasIdentity()) {
                $request->setModuleName("login")
                        ->setControllerName('index')
                        ->setActionName('index'); 
            } else {
                $identity = $this->_auth->getIdentity();
                if($this->_setRegistry($identity)){   


                } else { 
                    $request->setModuleName("login")
                            ->setControllerName('index')
                            ->setActionName('index'); 
                }
            }
        } else{
           // fb("Sin Verificacion");
            return;
        }
    } 
        
     /**
     * Guarda en registro los datos del usuario
     * @param Zend_Auth $identity
     * @return boolean 
     */
    protected function _setRegistry($identity){

        $userRepository = App_Doctrine_Repository::repository("Entities");
        $result = $userRepository->find(array("id" => $identity));
        if($result){
           Zend_Registry::set('user', ($result));   
           return true;
        } else {
           return false;
        }
    }
        
}

