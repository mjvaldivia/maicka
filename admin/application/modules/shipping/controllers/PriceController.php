<?php

class Shipping_PriceController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Shipping";
    
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
        $form = new Shipping_Form_PriceSearch(array('name'    => "search_price_list"));
        $form->renderForm();
        $this->view->form = $form;
    }
    
     /**
     * 
     * @param \Shipping_Form_Price $form
     */
    protected function _setNew(&$form){
        $this->_listCountryDeactivate($form);
    }
    
    /**
     * 
     * @param \Shipping_Form_Price $form
     * @param \Model\Entity\Shipping $entity
     */
    protected function _setEdit(&$form, $entity){

        $country = $entity->getCountry();
        if($country instanceof \Model\Entity\Country){
            $form->country->setValue($country->getId());
        }
        
        $form->price->setValue($entity->getPrice());
        
        $this->_listCountryDeactivate($form, $country->getId());
    }
    
    /**
     * Setea los campos
     * @param \Model\Entity\Shipping $entity
     * @param \Shipping_Form_Price $form
     */
    protected function _setProcess(&$entity, $form){
        $country = App_Doctrine_Action_Find::primary("Country", $form->getValue("country"));
        if($country instanceof \Model\Entity\Country){
            $entity->setCountry($country);
        }
        
        $entity->setPrice($form->getValue("price"));
    }
        
    /**
     * Retorna la clase que arma el formulario
     * @return \Shipping_Form_Price
     */
    protected function _getFormClass($parametros){
        $form = New Shipping_Form_Price($parametros);
        $form->renderForm();
        return $form;
    }
    
    /**
     * Desactiva los paises que ya tienen shipping
     * en el formulario
     * @param \Shipping_Form_Price $form
     * @param int $country_actual_id
     */
    protected function _listCountryDeactivate(&$form, $country_actual_id = null){
       
        $list = App_Doctrine_Action_Query::fetchAll("Country", "listWithShipping");
        $array = array();
        foreach($list as $country){
            if(!is_null($country_actual_id) AND $country_actual_id == $country->getId()){
                
            } else {
                $array[] = $country->getId();
            }
        }
        fb($array);
        if(count($array)>0){
            fb($array);
            $form->getElement("country")->setAttrib("disable", $array);
        }
        //throw new Exception();
    }
}

