<?php

Class Vendor_View_Helper_UserAvatar extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     *
     * @var \Model\Entity\Entities 
     */
    protected $_user;
    
    /**
     * Muestra el cuadro de avatar del usuario
     * @return string html
     */
    public function UserAvatar(){
        $this->_init();
        if(Zend_Registry::isRegistered("user")){
            $this->_user = Zend_Registry::get("user"); 

            $name = $this->_user->getName();

            $first_name = explode(" ", $name);

            $last_name = trim(str_replace($first_name[0], "", $name) );

            return $this->view->partial("user-avatar.phtml", array("user_first_name" => $first_name[0], "user_last_name" => $last_name));
        }
    }
}

