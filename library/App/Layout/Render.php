<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Layout_Render extends Zend_Controller_plugin_Abstract{ 
    
    /**
     * Carga el html del layout para cada modulo
     * @param Zend_Controller_Request_Abstract $request 
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request){ 
        
        $this->_cargaTemplate();
        
        $moduleName = $request->getModuleName();
        $this->_cargaJs($moduleName);
        $this->_cargaCss($moduleName);
    } 
    
    protected function _cargaTemplate() {
        
        $cliente_repository = App_Doctrine_Repository::repository("Clientes");
        if(APPLICATION_ENV == "production"){
           $cliente = $cliente_repository->findOneBy(array("url_produccion" => $_SERVER['HTTP_HOST'])); 
        }elseif(APPLICATION_ENV == "development"){
           $cliente = $cliente_repository->findOneBy(array("url_development" => $_SERVER['HTTP_HOST']));  
        }
        
        
        if($cliente instanceof \Model\Entity\Clientes){
            Zend_Layout::getMvcInstance()->setLayout("layout"); 
        
            $template = $cliente->getTemplate();
            Zend_Layout::getMvcInstance()->setLayoutPath(LIBRARY_PATH . $template->getUbicacion()); 
            
        }
    }
    
    /**
     * Carga el JS
     * @param string $modulo
     */
    protected function _cargaJs($modulo){
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('Layout')->getView();
        
        switch ($modulo){
            case "admin":
                $view->headScript()->appendFile('/admin/js/jquery-1.10.2.min.js');
                $view->headScript()->appendFile('/admin/js/jquery-ui-1.10.3.custom.min.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-transition.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-alert.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-modal.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-dropdown.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-scrollspy.js');
              //  $view->headScript()->appendFile('/admin/js/bootstrap-tab.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-scrollspy.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-tooltip.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-popover.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-button.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-collapse.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-carousel.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-typeahead.js');
                $view->headScript()->appendFile('/admin/js/bootstrap-tour.js');
                $view->headScript()->appendFile('/admin/js/jquery.cookie.js');
                $view->headScript()->appendFile('/admin/js/fullcalendar.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.dataTables.min.js');
                $view->headScript()->appendFile('/admin/js/excanvas.js');
                $view->headScript()->appendFile('/admin/js/jquery.flot.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.flot.pie.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.flot.stack.js');
                $view->headScript()->appendFile('/admin/js/jquery.flot.resize.min.js');
                $view->headScript()->appendFile('/admin/js/chosen.jquery.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.uniform.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.colorbox-min.js');
               // $view->headScript()->appendFile('/admin/js/jquery.cleditor.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.noty.js');
               // $view->headScript()->appendFile('/admin/js/jquery.elfinder.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.raty.min.js');
                $view->headScript()->appendFile('/admin/js/iphone-style-checkboxes.js');
                $view->headScript()->appendFile('/admin/js/jquery.autogrow-textarea.js');
                //$view->headScript()->appendFile('/admin/js/jquery.uploadify-3.1.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.liteuploader.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.history.js');
                $view->headScript()->appendFile('/admin/js/jquery.livequery.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.confirm.min.js');
                $view->headScript()->appendFile('/admin/js/charisma.js');
                $view->headScript()->appendFile('/js/confirm.js');
                $view->headScript()->appendFile('/admin/js/jquery.taglist.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.qtip.2.1.0.min.js');
                $view->headScript()->appendFile('/admin/js/jquery.typing-0.2.0.min.js');        
                $view->headScript()->appendFile('/admin/js/jquery.mask.min.js');  
                $view->headScript()->appendFile('/admin/js/jquery.jplayer.min.js'); 
                $view->headScript()->appendFile('/js/common/ajax.js', 'text/javascript')
                                   ->appendFile('/js/meiomask.js', 'text/javascript');
        
                break;
            default:

                break;
        }
    }
    
    /**
     * Carga el Css para cada modulo
     * @param string $modulo 
     */
    protected function _cargaCss($modulo){

        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('Layout')->getView();
        
        switch ($modulo){
            case "admin":
                $view->headLink()->appendStylesheet("/admin/css/bootstrap-responsive.css");
                
                $view->headLink()->appendStylesheet("/admin/css/jquery-ui-1.10.3.custom.min.css");
                $view->headLink()->appendStylesheet("/admin/css/fullcalendar.css");
                $view->headLink()->appendStylesheet("/admin/css/chosen.css");
                $view->headLink()->appendStylesheet("/admin/css/uniform.default.css");
                $view->headLink()->appendStylesheet("/admin/css/colorbox.css");
                //$view->headLink()->appendStylesheet("/admin/css/jquery.cleditor.css");
                $view->headLink()->appendStylesheet("/admin/css/jquery.noty.css");
                $view->headLink()->appendStylesheet("/admin/css/noty_theme_default.css");
                //$view->headLink()->appendStylesheet("/admin/css/elfinder.min.css");
                //$view->headLink()->appendStylesheet("/admin/css/elfinder.theme.css");
                $view->headLink()->appendStylesheet("/admin/css/iphone-style-checkboxes.css");
                $view->headLink()->appendStylesheet("/admin/css/opa-icons.css");
                //$view->headLink()->appendStylesheet("/admin/css/uploadify.css");
                $view->headLink()->appendStylesheet("/admin/css/jquery.taglist.css");
                $view->headLink()->appendStylesheet("/admin/css/jquery.qtip.css");
                $view->headLink()->appendStylesheet("/admin/css/charisma-app.css");
                $view->headLink()->appendStylesheet("/admin/css/jvideo.css");
                $view->headLink()->appendStylesheet('/admin/css/entity.css');
                break;
            default:
 
                break;
        }
    }
}
?>
