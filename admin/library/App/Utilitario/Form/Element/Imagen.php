<?php

require_once(APPLICATION_PATH . "/modules/imagegallery/library/Action/Helpers/ListImages.php");

class App_Utilitario_Form_Element_Imagen extends App_Utilitario_Form_Element_Abstract
{
    
    /**
     * Vista actual
     * @var type 
     */
    protected $_view;
    
    
    
    public function init() {
        $this->_setScript("imagen-element.phtml");
        parent::init();
        $this->_view->headScript()->appendFile('/js/plugins/jquery.uniform.min.js', 'text/javascript')
                                  ->appendFile('/js/plugins/jquery.liteuploader.min.js', 'text/javascript')
                                  ->appendFile('/js/plugins/jquery.wookmark.min.js', 'text/javascript')
                                  ->appendFile('/js/gallery.js', 'text/javascript');
        $this->_view->headLink()->appendStylesheet("/css/plugins/uniform.default.min.css");
        $this->_view->headScript()->appendFile('/js/upload.js', 'text/javascript');
    }
    
    /**
     * Configura el elemento
     * @param int $value
     */
    public function setValue($value) {
        $photo = App_Doctrine_Action_Find::primary("Photos", $value);
        if($photo instanceof \Model\Entity\Photos){
           $this->setAttribs(array("thumbnail" => $photo->getUrlSmall(),
                                   "fileurl"   => $photo->getUrlMedium(),
                                   "filename"  => $photo->getName()));
        }
        
        parent::setValue($value);
    }
    
    /**
     * Setea atributos
     * @param array $attribs
     */
    public function setAttribs(array $attribs) {
        
        if(!isset($attribs['thumbnail']) or $attribs['thumbnail'] == ""){
            $attribs['thumbnail'] = "/img/no-image.png";
        }
        
        if(!isset($attribs['filename'])){
            $attribs['filename'] = "";
        }
        
        if(!isset($attribs['fileurl'])){
            $attribs['fileurl'] = "";
        }
        
        if(!isset($attribs['title'])){
            $attribs['title'] = "";
        }
        
        
        $attribs["gallery"] = $this->_htmlGallery();
        
        parent::setAttribs($attribs);
    }
    
    /**
     * Retorna la galeria de imagenes
     * @return string html
     */
    protected function _htmlGallery(){
        $images = $this->_listImages();
        $list = New Helper_ListImages();
        return $list->formGalleryHtml($images);
    }
    
    /**
     * 
     * @param string $search
     * @return \Model\Entity\Photos array
     */
    protected function _listImages($search = "", $inicio = 0, $limite = 30){
        $list = New Helper_ListImages();
        return $list->listImages($search, $inicio, $limite);
    }
}

