<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Admin_UploadController extends Zend_Controller_Action{
    
     /**
     * Actions llamados por ajax
     * @var array 
     */
    public $ajaxable = array("imagen" => array("json"),
                             "archivo" => array("json"));
    
    /**
     *
     * @var string 
     */
    protected $_ruta = '/var/www/comparaclick/admin/public';
    
    public function init() {
        $this ->_helper->getHelper('AjaxContext')->initContext();
        parent::init();
    }
    
    /**
     * Index
     */
    public function indexAction(){
        
    }
    
    public function archivoAction(){
         $input_name = $this->_getParam("input_name");
         if (isset($_POST['liteUploader_id']) && $_POST['liteUploader_id'] == $input_name){
            foreach ($_FILES[$input_name]['error'] as $key => $error){
                if ($error == UPLOAD_ERR_OK){
                    $ruta =  $this->_ruta;
                    $dir = '/temp/' . time();
                    mkdir($ruta . $dir);
                    
                    $uploaded_url = $dir . "/" . $_FILES[$input_name]['name'][$key];
                    $uploaded_path = $ruta . $uploaded_url;
                    move_uploaded_file( $_FILES[$input_name]['tmp_name'][$key], $uploaded_path);
                    $this->view->url = $uploaded_url;
                }
            }
         }
    }
    
    /**
     * Sube una imagen
     */
    public function imagenAction(){
         $input_name = $this->_getParam("input_name");
         if (isset($_POST['liteUploader_id']) && $_POST['liteUploader_id'] == $input_name){
            foreach ($_FILES[$input_name]['error'] as $key => $error){
                if ($error == UPLOAD_ERR_OK){
                    
                    //$this->borrarArchivo();
                    
                    $ruta =  $this->_ruta;
                    $dir = '/temp/' . time();
                    mkdir($ruta . $dir);
                    
                    $uploaded_url = $dir . "/" . $_FILES[$input_name]['name'][$key];
                    
                    $uploaded_path = $ruta . $uploaded_url;
                    $uploaded_temp = "/var/www/comparaclick/admin/public/temp/" . $_FILES[$input_name]['name'][$key];
                    
                    move_uploaded_file($_FILES[$input_name]['tmp_name'][$key], $uploaded_temp);
                    
                    $image_magick = New App_Utilitario_ImageMagick();
                    $image_magick->imagenOriginal($uploaded_temp);
                    $image_magick->setSize("200", "200");
                    //$image_magick->setGravity();
                    $image_magick->imagenDestino($uploaded_path);
                    $image_magick->convert();
                    
                    $thumbnail = $ruta . $dir . "/thumbnail.jpg";
                    
                    $image_magick = New App_Utilitario_ImageMagick();
                    $image_magick->imagenOriginal($uploaded_path);
                    $image_magick->setSize(100, 100);
                    $image_magick->setGravity();
                    $image_magick->imagenDestino($thumbnail);
                    $image_magick->convert();

                    unlink($uploaded_temp);
                    $this->view->image = true;
                    $this->view->thumbnail = $dir . "/thumbnail.jpg";
                    $this->view->url = $uploaded_url;
    
                }
            }
        } 
    }
}
?>
