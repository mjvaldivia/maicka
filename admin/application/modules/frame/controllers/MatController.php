<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Frame_MatController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Mat";
    
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
        $form = new Frame_Form_MatSearch(array('name' => "search_mat_list"));
        $form->renderForm();
        $this->view->form = $form;
    }
    
     /**
     * 
     * @param \Frame_Form_Mat $form
     */
    protected function _setNew(&$form){
        
    }
    
    /**
     * 
     * @param \Frame_Form_Mat $form
     * @param \Model\Entity\Mat $entity
     */
    protected function _setEdit(&$form, $entity){
        
        $frame = $entity->getFrame();
        if($frame instanceof \Model\Entity\Frame){
            $id_frame = $frame->getId();
        }
        
        $photo_id = "";
        $photo = $entity->getPhoto();
        if($photo instanceof \Model\Entity\Photos){
            $photo_id = $photo->getId();
        }

        $form->populate(array(
                "activo" => $entity->getActive(),
                "name" => $entity->getName(),
                "letter_quantity" => $entity->getLetterQuantity(),
                "art"  => $photo_id,
                "frame" => $id_frame
        ));
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\Mat $entity
     * @param \Frame_Form_Mat $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setName($form->getValue("name"));
        $entity->setLetterQuantity($form->getValue("letter_quantity"));
        $entity->setActive($form->getValue("activo"));
        
        $frame = App_Doctrine_Action_Find::primary("Frame", $form->getValue("frame"));
        if($frame instanceof \Model\Entity\Frame){
            $entity->setFrame($frame);
        }
        
        $this->_helper->AssignPhoto->save($entity, $this->_getParam("art_id"));
    }

    
    /**
     * Retorna la clase que arma el formulario
     * @return \Zend_form
     */
    protected function _getFormClass($parametros){
        $form = New Frame_Form_Mat($parametros);
        $form->renderForm();
        return $form;
    }
}
?>
