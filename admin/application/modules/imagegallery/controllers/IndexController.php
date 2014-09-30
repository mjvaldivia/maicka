<?php

class Imagegallery_IndexController extends Zend_Controller_Action{
    
    public $ajaxable = array("delete" => array("json"),
                             "load-more" => array("json"),
                             "load-more-form" => array("json"));
    
    /**
     * Init
     */
    public function init() {
        parent::init();
        
        Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.'/modules/imagegallery/library/Action/Helpers', 'Helper');
        
        $this ->_helper->getHelper('AjaxContext')->initContext();
        $this->view->headScript()->appendFile('/js/plugins/dropzone/dropzone.min.js', 'text/javascript');
        $this->view->headScript()->appendFile('/js/plugins/jquery.wookmark.min.js', 'text/javascript');
        $this->view->headScript()->appendFile('/js/image-manager.js', 'text/javascript');
        $this->view->headLink()->appendStylesheet("/css/plugins/dropzone/css/dropzone.css");    
    }
    
    /**
     * 
     */
    public function indexAction(){
        $this->view->search = $this->_getParam("search");
    }
    
    /**
     * Carga mas resultados a la galeria
     */
    public function loadMoreAction(){
        $search = $this->_getParam("search");
        $inicio = $this->_getParam("inicio");
        
        $append = $this->view->Gallery($search, $inicio);
        $this->view->append = $append;
        $this->view->inicio = $inicio + 50;
        
        if($append == ""){
            $this->view->fin = true;
        } else {
            $this->view->fin = false; 
        }
    }
    
    /**
     * Carga mas resultados a la galeria del elemento imagen
     * del formulario
     */
    public function loadMoreFormAction(){
        $search = $this->_getParam("search");
        $inicio = $this->_getParam("inicio");
        
        $list = $this->_helper->ListImages->listImages($search, $inicio, 30);
        $append = $this->_helper->ListImages->formGalleryHtml($list);
        $this->view->append = $append;
        $this->view->inicio = $inicio + 30;
        
        if($append == ""){
            $this->view->fin = true;
        } else {
            $this->view->fin = false; 
        }
    }
    
    /**
     * Borra una imagen
     */
    public function deleteAction(){
        $this->_helper->AssignPhoto->remove($this->_getParam("id"));
    }
}

