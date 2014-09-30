<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Configuracion base para la vista
     */
    public function _initView(){
        $view = new Zend_View($this->getOptions());

        $view->doctype("HTML5");
        $view->headTitle()->setSeparator(" :: ")
                          ->append("Cabañas Maicka");

        $view->headMeta()
                ->setCharset("utf-8")
                ->appendName('viewport', 'width=device-width, initial-scale=1, minimum-scale=1.0');
        
        $view->headLink(array("rel" => "shortcut icon", "href" => "/img/favicon.ico"), "PREPEND")
                ->appendStylesheet("/css/bootstrap/bootstrap.min.css", "screen")
                ->appendStylesheet("/css/bootstrap/bootstrap-responsive.min.css", "screen")
                ->appendStylesheet("/css/style.css", "screen")
                ->appendStylesheet("/css/style-reponsive.css", "screen")
                ->appendStylesheet("/css/js/slider/default.css", "screen")
                ->appendStylesheet("/css/nivo-slider.css", "screen")
                ->appendStylesheet("/css/socialcount-with-icons.css", "screen");
        
        

        $view->headScript()
                ->appendFile('http://maps.google.com/maps/api/js?sensor=false', 'text/javascript')
                ->appendFile('/js/jquery.js', 'text/javascript')
                ->appendFile('/js/jquery-ui.js', 'text/javascript')
                ->appendFile('/js/bootstrap/bootstrap.js', 'text/javascript')
                ->appendFile('/js/jquery.nivo.slider.js', 'text/javascript')
                ->appendFile('/js/socialcount.min.js', 'text/javascript')
                ->appendFile('/js/jquery.quicksand.js', 'text/javascript')
                ->appendFile('/js/global.js', 'text/javascript');
        
        //Initialize and/or retrieve a ViewRenderer object on demand via the helper broker
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->initView();

        //add the global helper directory path        
        $viewRenderer->view->addHelperPath(APPLICATION_PATH . '/../library/Alpha/Layout/Helpers', 'Alpha_View_Helper');

        $viewRenderer->view->env = APPLICATION_ENV;
        $viewRenderer->view->defaultCountry = 1;
    }
    
    
    /**
     * Inicia el timezone
     */
     protected function _initLocale(){
        date_default_timezone_set("America/Toronto");
        $locale = new Zend_Locale('en_US');
        Zend_Registry::set('Zend_Locale', $locale);
     }

  
     
    /**
     * Carga la configuracion de zend en el registro
     * @return Zend_Config 
     */
    protected function _initConfig()
    {
        $configArray = $this->getOptions();
        $config = new Zend_Config($configArray);

        // Add to Zend Registry
        Zend_Registry::set('config', $config);
        return $config;
    } 
     
    /**
     * Inicia doctrine
     */
    public function _initAutoloaderNamespaces()
    {
         require_once 'Doctrine/Common/ClassLoader.php';

         $autoloader = \Zend_Loader_Autoloader::getInstance();
         $symfonyAutoloader = new \Doctrine\Common\ClassLoader('Symfony', 'Doctrine');
         $autoloader->pushAutoloader(array($symfonyAutoloader, 'loadClass'), 'Symfony');
    }
    
    /**
     * Crea los Router
     */
    protected function _initRoute() {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $routes["cart"] = new Zend_Controller_Router_Route(
                '/cart', array(
                    'module' => "cart",
                    'controller' => "index",
                    'action' => "list"
                )
        );

        $router->addRoutes($routes);
    }

    /**
     * Inicia el soporte para firephp
     * @return Zend_Log 
     */
    protected function _initFireLog()
    {
        if ($this->getEnvironment() == 'production') return false;

        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Firebug();
        $writer->setEnabled($this->getResource('config')->phpSettings->display_errors); // For Db_Profiler
        $logger->addWriter($writer);

        $registry = $this->getResource('Registry');
        $registry['firebugLogger'] = $logger;
        Zend_Registry::set('firebugLogger', $registry['firebugLogger']); // deprecated
        
        return $logger;
    }
    
    /**
     * Inicializando Debug para development
     */
//    protected function _initZFDebug(){
//        if (APPLICATION_ENV == 'development') {
//            $autoloader = Zend_Loader_Autoloader::getInstance();
//            $autoloader->registerNamespace('ZFDebug');
//            $em = $this->bootstrap('doctrine')->getResource('doctrine')->getEntityManager();
//            
//            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strcasecmp('XMLHttpRequest', $_SERVER['HTTP_X_REQUESTED_WITH']) === 0){
//                $em->getConnection()->getConfiguration()->setSQLLogger(new \ZendX\Doctrine2\FirebugProfiler());
//            } else {
//                $em->getConnection()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());
//            }
//            $options = array(
//                'plugins' => array(
//                    'Variables',
//                    'ZFDebug_Controller_Plugin_Debug_Plugin_Doctrine2'  => array(
//                        'entityManagers' => array($em),
//                    ),
//                    'File'          => array('basePath' => APPLICATION_PATH . '/application'),
//                    'Cache'       => array('backend' => App_Cache_Set::cacheEterno()),
//                    'Exception',
//                    'Html',
//                    'Memory',
//                    'Time',
//                    'Registry',
//                )
//            );
//
//            $debug = new ZFDebug_Controller_Plugin_Debug($options);
//            $this->bootstrap('frontController');
//            $frontController = $this->getResource('frontController');
//            $frontController->registerPlugin($debug);
//        } 
//    }
}

/**
 * fb
 * Firebug debugger function. A shortcut to Zend_Registry::get('logger')->debug($message);
 * Put this here as I like to keep index.php as clear as possible
 *
 * @param mixed
 * @param string
 */
function fb($message, $label=null)
{
    if (!Zend_Registry::isRegistered('firebugLogger')) return false;

    if ($label!=null) {
        $message = array($label,$message);
    }
    Zend_Registry::get('firebugLogger')->debug($message);
}

?>
