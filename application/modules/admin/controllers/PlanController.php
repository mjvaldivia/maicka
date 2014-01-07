<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      MJ Valdivia<mj.valdivia@shorthillsolutions.com>
 */

class Admin_PlanController extends App_Modulo_Mantenedor_Class{
        
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Plan";
    
    /**
     * Proveedor al cual pertenece el plan
     * @var \Model\Entity\Proveedor 
     */
    protected $_proveedor;

    /**
     * Init
     */
    public function init() {
        $this->ajaxable = array_merge($this->ajaxable, array("reorder" => array("json")));
        parent::init();
        $this->_setProveedor($this->_getParam("proveedor"));
    }
    
    /**
     * Index
     */
    public function indexAction() {
        parent::indexAction();
        $this->view->search_form = $this->_getSearchForm();
    }
        
    /**
     * Setea el property type
     * @param int $property_type_id
     */
    protected function _setProveedor($proveedor_id){
        $proveedor = App_Doctrine_Action_Find::primary("Proveedor", $proveedor_id);
        if($proveedor instanceof \Model\Entity\Proveedor){
            $this->_proveedor = $proveedor;
            $this->view->id_proveedor   = $proveedor->getId();
            $this->view->proveedor_name = $proveedor->getName();
        } else throw new Exception("No existe el proveedor");
    }
    
    /**
     * Setea los campos de la tabla con los del formulario
     * @param \Model\Entity\Plan $entity
     * @param \Admin_Form_Plan $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setname($form->getValue("plan_nombre"));
        $entity->setDescripcion($form->getValue("plan_description"));
        $entity->setSobrecargo($form->getValue("plan_sobrecargo"));
        $entity->setEdadMaxima($form->getValue("plan_edad"));
        $entity->setActive($form->getValue("active"));
        
        
        // Elimina las zonas y las agrega de nuevo
        $lista_motivos = $entity->listarMotivos();
        if(count($lista_motivos)>0){
            foreach($lista_motivos as $motivo){ 
               $lista_motivos->removeElement($motivo);
            }
        }

        foreach ($form->getValue("plan_motivo") as $key => $value){
            $motivo = App_Doctrine_Action_Find::primary("MotivoViaje", $value);
            if($motivo instanceof \Model\Entity\MotivoViaje){
                    $lista_motivos->add($motivo);
            }
        }

        $zona = App_Doctrine_Action_Find::primary("Zona", $form->getValue("plan_zona"));
        if($zona instanceof \Model\Entity\Zona){
            $entity->setZona($zona);
        }
       
        $entity->setProveedor($this->_proveedor);

        $archivo_url = $this->_getParam("plan_archivo_url");
        if($archivo_url!=""){
            if($entity->getDocumento()!=$archivo_url){
              /**********/
              $ruta = "/var/www/comparaclick/admin/public";
              $archivo_anterior = $ruta . $entity->getDocumento();
              @unlink($archivo_anterior);

              $directorios = explode("/", $entity->getDocumento());
              unset($directorios[count($directorios)-1]);
              //@unlink($ruta . "/" . implode("/", $directorios) . "/thumbnail.jpg");
              @rmdir($ruta . "/" . implode("/", $directorios));
              /**********/
              
              $imagen_subida = explode("/", $archivo_url);
              $this->full_copy($ruta . "/temp/" . $imagen_subida[2], 
                               "/var/www/comparaclick/admin/public/doc/upload/" . $imagen_subida[2]);
              $entity->setDocumento("/doc/upload/" . $imagen_subida[2] . "/" .$imagen_subida[3]);
            }
        }
    }
    
    function full_copy( $source, $target ) { 
        if ( is_dir( $source ) ) { 
            @mkdir( $target ); 
            $d = dir( $source ); 
            while ( FALSE !== ( $entry = $d->read() ) ) { 
                if ( $entry == '.' || $entry == '..' ) { continue; } 
                $Entry = $source . '/' . $entry; 
                if ( is_dir( $Entry ) ) { 
                    full_copy( $Entry, $target . '/' . $entry ); 
                    continue; 
                    
                } 
                copy( $Entry, $target . '/' . $entry ); 
                
            } 
            
            $d->close(); 
        }else { copy( $source, $target ); 
        
        } 
        
    }
    
    /**
     * Carga los campos al formulario
     * @param \Admin_Form_Plan $form
     * @param \Model\Entity\Plan $entity
     */
    protected function _setEdit(&$form, $entity){     
        $form->plan_nombre->setValue($entity->getName());
        $form->plan_description->setValue($entity->getDescripcion());
        $form->plan_sobrecargo->setValue($entity->getSobrecargo());
        $form->plan_edad->setValue($entity->getEdadMaxima());
        $form->active->setValue($entity->getActive());
        
        $array = array();
        $lista_motivos = $entity->listarMotivos();
        foreach($lista_motivos as $motivo){
            $array[] = $motivo->getId();
        }
        $form->plan_motivo->setValue($array);

        $zona = $entity->getZona();
        if($zona){
             $form->plan_zona->setValue($zona->getId());
        }
        
        $archivo = $entity->getDocumento();
        $ruta_separada = explode("/", $archivo);
        $form->plan_archivo->setAttribs(array(
                                        "filename" => $ruta_separada[count($ruta_separada)-1]));
        $form->plan_archivo->setValue($entity->getDocumento());
    }
    
    
    /**
     * Retorna la clase del formulario
     */
    protected function _getFormClass($parametros){
        $form = New Admin_Form_Plan($parametros);
        $form->renderForm();
        $form->active->setValue(true);
        $form->proveedor->setValue($this->_proveedor->getId());
        return $form;
    }
    
    /**
     * Retorna URl de retorno
     * @return string
     */
    protected function _redirectUrl(){
        return "/" . $this->getRequest()->getModuleName() . "/" . $this->getRequest()->getControllerName() ."/index/proveedor/".$this->_proveedor->getId();
    }
    
    /**
     * Formulario de busqueda
     * @return \Admin_Form_SearchPlan
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
        
        
        $form = New Admin_Form_SearchPlan($parametros);
        $form->renderForm();
        $form->plan_active->setValue(1);
        return $form;
    }
}
?>
