<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Letterart_IndexController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "LetterArt";
    
    /**
     * Init
     */
    public function init() {
        parent::init();
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/imagegallery/library/Action/Helpers', 'Helper');
    }
    
    /**
     * Index
     */
    public function indexAction() {
        $form = new Letterart_Form_ArtSearch(array('name' => "search_letter_art"));
        $form->renderForm();
        $this->view->form = $form;
    }
    
     /**
     * 
     * @param \Letterart_Form_Art $form
     */
    protected function _setNew(&$form){
        
    }
    
    /**
     * 
     * @param \Letterart_Form_Art $form
     * @param \Model\Entity\LetterArt $entity
     */
    protected function _setEdit(&$form, $entity){
        
        $id_category = "";
        $category = $entity->getCategory();
        if($category instanceof \Model\Entity\LetterCategory){
            $id_category = $category->getId();
        }
        
        $photo_id = "";
        $photo = $entity->getPhoto();
        if($photo instanceof \Model\Entity\Photos){
            $photo_id = $photo->getId();
        }
        
        $form->populate(array(
                "activo" => $entity->getActive(),
                "default" => $entity->getDefault(),
                "name" => $entity->getName(),
                "letter" => $entity->getLetter(),
                "art"  => $photo_id,
                "category" => $id_category
        ));
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\LetterArt $entity
     * @param \Letterart_Form_Art $form
     */
    protected function _setProcess(&$entity, $form){        
        $entity->setName($form->getValue("name"));
        $entity->setActive($form->getValue("activo"));
        $entity->setLetter($form->getValue("letter"));
        
        if ($form->getValue("default") == 1){
            App_Doctrine_Repository::repository("LetterArt")->resetDefaultByLetter($form->getValue("letter"));
        }
        $entity->setDefault($form->getValue("default"));
        
        $category = App_Doctrine_Action_Find::primary("LetterCategory", $form->getValue("category"));
        if($category instanceof \Model\Entity\LetterCategory){
            $entity->setCategory($category);
        }

        $this->_helper->AssignPhoto->save($entity, $this->_getParam("art_id"));
    }
    
    /**
     * Se ejecuta cuando hay error en el formulario
     * @param Letterart_Form_Art  $form
     */
    protected function _setPostError($form){
        $form->art->setValue($this->_getParam("art_id"));
    }

    
    /**
     * Retorna la clase que arma el formulario
     * @return \Zend_form
     */
    protected function _getFormClass($parametros){
        $form = New Letterart_Form_Art($parametros);
        $form->renderForm();
        return $form;
    }
}
?>
