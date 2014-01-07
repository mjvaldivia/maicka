<?php
/**
 * Shorthill
 *
 * @category    App
 * @package     Doctrine
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Doctrine_Repository{
    
    static private $instance = false;
    
    private $_entityManager;
    
    /**
     * 
     */
    function __construct() {
        $this->_entityManager = Zend_Registry::get('doctrine')->getEntityManager();
    }
    
    /**
     * Devuelve el entity manager
     * @return type 
     */
    public function getEntityManager(){
        return $this->_entityManager;
    }
    
    
    /**
     * Recupera el repositorio
     * @param string $entity
     * @return Doctrine\ORM\EntityRepository 
     */
    public function getRepository($entity = ""){
        if($entity=="") return $this->getEntityManager();
        else return $this->_entityManager->getRepository($entity);
    }
    
    
    /**
     * Recupera la clase repositorio
     * @param string $entity nombre de la clase que representa a la BD
     * @return /Model/Entity/Repository 
     */
    static public function repository($entity = ""){
        
        if(!self::$instance){
            self::$instance = New App_Doctrine_Repository();
        }
       if($entity=="") $model = "";
       else $model = "\Model\Entity\\" . $entity;
       return self::$instance->getRepository($model);
    }
    
    /**
     * Devuelve el entity manager de doctrine
     * @return Doctrine\ORM\EntityManager
     */
    static public function entityManager(){
        if(!self::$instance){
            self::$instance = New App_Doctrine_Repository();
        }
        return self::$instance->getEntityManager();
    }
    
   
} 

?>
