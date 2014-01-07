<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      MJ Valdivia<mj.valdivia@shorthillsolutions.com>
 */

class Admin_ProveedorController extends App_Modulo_Mantenedor_Class{
    
    /**
     * Entidad a modificar
     * @var string 
     */
    protected $_entity = "Proveedor";
    
    /**
     * Index
     */
    public function indexAction() {
        parent::indexAction();
        $this->view->search_form = $this->_getSearchForm();
    }
    
    /**
     * Setea los campos de la tabla con los del formulario
     * @param \Model\Entity\Proveedor $entity
     * @param \Admin_Form_Proveedor $form
     */
    protected function _setProcess(&$entity, $form){
        $entity->setname($form->getValue("name"));
        $entity->setDescripcion($form->getValue("descripcion"));
        $entity->setCondGrales($form->getValue("condiciones"));
        $entity->setActive($form->getValue("active"));
        
        $imagen_url = $this->_getParam("imagen_url");
        if($imagen_url!=""){
           if($entity->getImgPath()!=$imagen_url){
              /**********/
              $ruta = "/var/www/comparaclick/admin/public";
              $archivo_anterior = $ruta . $entity->getImgPath();
              @unlink($archivo_anterior);

              $directorios = explode("/", $entity->getImgPath());
              unset($directorios[count($directorios)-1]);
              @unlink($ruta . "/" . implode("/", $directorios) . "/thumbnail.jpg");
              @rmdir($ruta . "/" . implode("/", $directorios));
              /**********/
              
              $imagen_subida = explode("/", $imagen_url);
              $this->full_copy($ruta . "/temp/" . $imagen_subida[2], 
                               "/var/www/comparaclick/admin/public/images/upload/" . $imagen_subida[2]);
              $entity->setImgPath("/images/upload/" . $imagen_subida[2] . "/" .$imagen_subida[3]);
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
     * @param \Admin_Form_Proveedor $form
     * @param \Model\Entity\Proveedor $entity
     */
    protected function _setEdit(&$form, $entity){     
        $form->name->setValue($entity->getName());
        $form->descripcion->setValue($entity->getDescripcion());
        
        $imagen = $entity->getImgPath();
        $ruta_separada = explode("/", $imagen);
        
        $form->imagen->setAttribs(array("thumbnail" => $entity->getImgPath(),
                                        "filename" => $ruta_separada[count($ruta_separada)-1]));
        $form->imagen->setValue($entity->getImgPath());
        
        $form->condiciones->setValue($entity->getCondGrales());
        $form->active->setValue($entity->getActive());
    }
    
    /**
     * Retorna la clase del formulario
     */
    protected function _getFormClass($parametros){
        $form = New Admin_Form_Proveedor($parametros);
        $form->renderForm();
        $form->active->setValue(true);
        return $form;
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
        $form = New Admin_Form_SearchProveedor($parametros);
        $form->renderForm();
        $form->proveedor_active->setValue(1);
        return $form;
    }
}
?>
