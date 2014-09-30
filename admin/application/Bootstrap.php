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
     * Setea el tiempo maximo de ejecucion
     */
    protected function _initExecutionTime(){
     /*   set_time_limit(0);
        Zend_Layout::startMvc();*/
    }

    /**
     * Configuracion base para la vista
     * El resto se configura en la clase Phaloo_Layout_Render
     */
    public function _initView(){
        $view = new Zend_View($this->getOptions());
       
        $view->doctype("HTML5");
        $view->headTitle()->setSeparator(" :: ")
                          ->append("Alphabet Photo Pics - Admin");

        $view->headMeta()->setCharset("utf-8")
                         ->setName('viewport', 'width=device-width, initial-scale=1.0');
        
                         // GLOBAL STYLES
        $view->headLink()->appendStylesheet("/css/plugins/bootstrap/css/bootstrap.min.css", "screen")
                         ->appendStylesheet("http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic", "screen")
                         ->appendStylesheet("http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800", "screen")
                         ->appendStylesheet("/css/font-awesome/css/font-awesome.min.css", "screen")
                         // THEME STYLES
                         ->appendStylesheet("/css/style.css", "screen")
                         ->appendStylesheet("/css/plugins.css", "screen")
                         // DEMO STYLES
                         ->appendStylesheet("/css/demo.css", "screen")
                         ->appendStylesheet("/css/chosen.min.css", "screen");
        
        
                           // GLOBAL SCRIPTS
        $view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', 'text/javascript')
                           ->appendFile('/js/plugins/bootstrap/bootstrap.min.js', 'text/javascript')
                           ->appendFile('/js/plugins/slimscroll/jquery.slimscroll.min.js', 'text/javascript')
                           ->appendFile('/js/plugins/jquery.livequery.min.js', 'text/javascript')
                           ->appendFile('/js/plugins/popupoverlay/jquery.popupoverlay.js')
                           ->appendFile('/js/plugins/popupoverlay/defaults.js')
                           // HISRC Retina Images
                           ->appendFile('/js/plugins/popupoverlay/logout.js')
                           ->appendFile('/js/plugins/hisrc/hisrc.js', 'text/javascript')
                           // THEME SCRIPTS
                           ->appendFile('/js/flex.js', 'text/javascript')
                           ->appendFile('/js/plugins/jquery.confirm.min.js', 'text/javascript')
                           ->appendFile('/js/confirm.js', 'text/javascript')
                           ->appendFile('/js/plugins/chosen.jquery.min.js', 'text/javascript');
        
        //Initialize and/or retrieve a ViewRenderer object on demand via the helper broker
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->initView();

        //add the global helper directory path
        $viewRenderer->view->addHelperPath(APPLICATION_PATH . '/../library/Vendor/Flex/helpers','Vendor_View_Helper');
        $viewRenderer->view->addHelperPath(APPLICATION_PATH . '/../library/Admin/Layout/Helpers/View','Admin_View_Helper');

        
        $view->env = APPLICATION_ENV;
       
    }
    
    
    /**
     * Inicia el timezone
     */
     protected function _initLocale(){
        date_default_timezone_set("America/New_York");
        $locale = new Zend_Locale('en_US');
        Zend_Registry::set('Zend_Locale', $locale);
     }

    /**
      * Añade un directorio para modulos usados para 
      * modulos de App
      */
    protected function _initModulesDirectory(){
        $front = Zend_Controller_Front::getInstance();
        $front->addControllerDirectory(APPLICATION_PATH."/../library/App/Grid2/Controller","grid2");
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
   /* protected function _initZFDebug(){
        if (APPLICATION_ENV == 'development') {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace('ZFDebug');
            $em = $this->bootstrap('doctrine')->getResource('doctrine')->getEntityManager();
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strcasecmp('XMLHttpRequest', $_SERVER['HTTP_X_REQUESTED_WITH']) === 0){
                $em->getConnection()->getConfiguration()->setSQLLogger(new \ZendX\Doctrine2\FirebugProfiler());
            } else {
                $em->getConnection()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());
            }
            $options = array(
                'plugins' => array(
                    'Variables',
                    'ZFDebug_Controller_Plugin_Debug_Plugin_Doctrine2'  => array(
                        'entityManagers' => array($em),
                    ),
                    'File'          => array('basePath' => APPLICATION_PATH . '/application'),
                    'Cache'       => array('backend' => App_Cache_Set::cacheEterno()),
                    'Exception',
                    'Html',
                    'Memory',
                    'Time',
                    'Registry',
                )
            );

            $debug = new ZFDebug_Controller_Plugin_Debug($options);
            $this->bootstrap('frontController');
            $frontController = $this->getResource('frontController');
            $frontController->registerPlugin($debug);
        } 
    }*/
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
