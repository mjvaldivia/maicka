<?php

class Item_IndexController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Item";
    
    /**
     * Init
     */
    public function init() {
        parent::init();
    }
    
    /**
     * Index
     */
    public function indexAction() {
        $form = new Item_Form_ItemSearch(array('name' => "search_item_master"));
        $form->renderForm();
        $this->view->form = $form;
    }
    
     /**
     * 
     * @param \Item_Form_Item $form
     */
    protected function _setNew(&$form){
        
    }
    
    /**
     * 
     * @param \Item_Form_Item $form
     * @param \Model\Entity\Item $entity
     */
    protected function _setEdit(&$form, $entity){
        
        $frame = $entity->getFrame();
        if($frame instanceof \Model\Entity\Frame){
            $id_frame = $frame->getId();
        }
        
        $form->populate(array(
                "name" => $entity->getName(),
                "frame"  => $id_frame,
                "quantity" => $entity->getLetterQuantity(),
                "price_cdn" => $entity->getPriceCdn(),
                "price_usa" => $entity->getPriceUsa()
        ));
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\Item $entity
     * @param \Item_Form_Item $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setName($form->getValue("name"));
        $entity->setLetterQuantity($form->getValue("quantity"));
        $entity->setPriceCdn($form->getValue("price_cdn"));
        $entity->setPriceUsa($form->getValue("price_usa"));
        
        $frame = App_Doctrine_Action_Find::primary("Frame", $form->getValue("frame"));
        if($frame instanceof \Model\Entity\Frame){
            $entity->setFrame($frame);
        }
    }

    
    /**
     * Retorna la clase que arma el formulario
     * @return \Zend_form
     */
    protected function _getFormClass($parametros){
        $form = New Item_Form_Item($parametros);
        $form->renderForm();
        return $form;
    }
}

