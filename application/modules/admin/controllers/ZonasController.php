<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      MJ Valdivia<mj.valdivia@shorthillsolutions.com>
 */

class Admin_ZonasController extends App_Modulo_Mantenedor_Class{
        
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Zona";
       
    public function indexAction() {
        parent::indexAction();
        $this->view->search_form = $this->_getSearchForm();
    }
    
    
    /**
     * Setea los campos de la tabla con los del formulario
     * @param \Model\Entity\Zona $entity
     * @param \Admin_Form_Zona $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setName($form->getValue("name"));
        $entity->setActive($form->getValue("active"));
        
        $lista_paises = $entity->listPaises();
        foreach($lista_paises as $pais){ 
           $lista_paises->removeElement($pais);
        }

        foreach ($form->getValue("zona_pais") as $key => $value){
            //echo"<pre>";print_r($value);echo"</pre>";
            $pais = App_Doctrine_Action_Find::primary("Pais", $value);
            if($pais){
                    $lista_paises->add($pais);
            }
        }
        
    }
        
    /**
     * Carga los campos al formulario
     * @param \Admin_Form_Tarifa $form
     * @param \Model\Entity\Tarifa $entity
     */
    protected function _setEdit(&$form, $entity){     
        
        $form->name->setValue($entity->getName());
        $form->active->setValue($entity->getActive());
   
        
        $array = array();
        $lista_paises = $entity->listPaises();
        foreach($lista_paises as $pais){
            $array[] = $pais->getId();
        }
        $form->zona_pais->setValue($array);
    }
    
    /**
     * Retorna la clase del formulario
     */
    protected function _getFormClass($parametros){
        $form = New Admin_Form_Zona($parametros);
        $form->renderForm();
        return $form;
    }
    
    /**
     * Retorna URl de retorno
     * @return string
     */
    protected function _redirectUrl(){
        return "/" . $this->getRequest()->getModuleName() . "/" . $this->getRequest()->getControllerName() ."/index";
    }
    
    /**
     * Formulario de busqueda
     * @return \Admin_Form_SearchOrdenes
     */
    protected function _getSearchForm(){
        $parametros = array(
                            'name'    => 'search',
                            'action'  => "",
                            'method'  => 'post',
                            'prefixPath' => array("path" => "App/Utilitario/Form",
                                                  "prefix" => "App_Utilitario_Form",
                                                  "type"   => \Zend_Form::ELEMENT)
                           );
        $form = New Admin_Form_SearchZona($parametros);
        $form->renderForm();

        return $form;
    }
    
}
?>
