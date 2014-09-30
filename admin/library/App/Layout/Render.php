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
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOptions(); 
        
        if (isset($config['resources']['layout']['layout'])) { 
            $layoutScript = $config['resources']['layout']['layout']; 
            Zend_Layout::getMvcInstance()->setLayout($layoutScript); 
        } 
        
        if (isset($config['resources']['layout']['layoutPath'])) { 
            $layoutPath = $config['resources']['layout']['layoutPath']; 
            Zend_Layout::getMvcInstance()->setLayoutPath($layoutPath); 
        } 
        
        
        /*$view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $view->addHelperPath(APPLICATION_PATH . '/../library/App/Modulo/Flex/helpers', 'App_View_Helper');*/
        
    } 
    
    
}
?>
