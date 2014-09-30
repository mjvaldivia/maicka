<?php

require_once(APPLICATION_PATH . "/modules/imagegallery/library/Action/Helpers/ListImages.php");

Class Zend_View_Helper_Gallery extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    

    
    
    
    /**
     * Muestra la galeria de imagenes
     * @param string $search
     */
    public function Gallery($search, $inicio = 0, $limite = 50){
        $this->_init();
        $images = $this->_listImages($search, $inicio, $limite);
       // $this->_setTotal($search);
        foreach($images as $photo){
            $name_corto = substr($photo->getName(), 0, 10) . "...";
            $imageSize = "";
            if (is_file(APPLICATION_PATH."/../public".$photo->getUrlSmall())){
                $imageInfo = getimagesize(APPLICATION_PATH."/../public".$photo->getUrlSmall());
                $imageWidth = 112;
                $imageHeight = ($imageInfo[1] * $imageWidth) / $imageInfo[0];
                $imageSize = sprintf("width=\"%d\" heigth=\"%d\"", $imageWidth, $imageHeight);
            }
            
            $this->_addHtml($this->view->partial("gallery-item.phtml", array("id" => $photo->getId(),
                                                                             "img_url" => $photo->getUrlSmall(),
                                                                             "imageSize" => $imageSize,
                                                                             "name" => $photo->getName(),
                                                                             "name_corto" => $name_corto)));   
        }
        return $this->_getHtml();
    }
    
    /**
     * 
     * @param string $search
     * @return \Model\Entity\Photos array
     */
    protected function _listImages($search = "", $inicio, $limite){
        $list = New Helper_ListImages();
        return $list->listImages($search, $inicio, $limite);
    }
    
    
    
}

