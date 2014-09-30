<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Helper_AssignPhoto extends Zend_Controller_Action_Helper_Abstract{
    
    /**
     *
     * @var \Model\Entity\Photos
     */
    protected $_new_image;
    
    /**
     *
     * @var \Model\Entity\Photos
     */
    protected $_old_image;
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $_entity_manager;
    
    /**
     * Constructor: inicializa el helper
     * 
     * @return void
     */
    public function __construct(){
        $this->_entity_manager = App_Doctrine_Repository::entityManager();
    }
    
    /**
     * Guarda la imagen en la entidad
     * @param \Model\Entity\XXXX $entity
     * @param int $photo_id id de la imagen
     */
    public function save(&$entity, $photo_id){
        if(method_exists($entity, "getPhoto")){
            
            $this->_new_image = App_Doctrine_Action_Find::primary("Photos", $photo_id);
            if($this->_new_image instanceof \Model\Entity\Photos){
            
                $this->_old_image = $entity->getPhoto();
                if($this->_old_image instanceof \Model\Entity\Photos){
                    if($this->_old_image->getId() != $this->_new_image->getId()){
                        if(!$this->_old_image->getGallery()){
                            $this->remove($this->_old_image->getId());
                        }
                    }
                }
                
                $entity->setPhoto($this->_new_image);
                
            } 
            
        } else throw new Exception("La entidad no tiene la tabla photos relacionada");
    }
    
    /**
     * Borra la imagen del disco y de la BD
     * @param int $photo_id
     */
    public function remove($photo_id){
        $photo = App_Doctrine_Action_Find::primary("Photos", $photo_id);
        if($photo instanceof \Model\Entity\Photos){
           
           $dir = dirname($photo->getPathOriginal());
            
           @unlink($photo->getPathSmall());
           @unlink($photo->getPathMedium());
           @unlink($photo->getPathOriginal());
           
           rmdir($dir);
           //fb($dir);
          
           $this->_entity_manager->remove($photo);
           $this->_entity_manager->flush();
        }
    }
}

