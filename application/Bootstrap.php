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
     * El resto se configura en la clase Phaloo_Layout_Render
     */
    public function _initView(){
        $view = new Zend_View($this->getOptions());
       // $options = $this->getOptions();

        $view->doctype("HTML5");
        $view->headTitle()->setSeparator(" - ")
                          ->append("Comparaclick - Administrador");

        $view->headMeta()->setCharset("utf-8");
        
                       
       // $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');

        $view->env = APPLICATION_ENV;
       

    }
    
    
    /**
     * Inicia el timezone
     */
     protected function _initLocale(){
        date_default_timezone_set("America/Santiago");
        $locale = new Zend_Locale('es_CL');
        Zend_Registry::set('Zend_Locale', $locale);
     }

    /**
      * Añade un directorio para modulos usados para 
      * modulos de App
      */
    protected function _initModulesDirectory(){
        $front = Zend_Controller_Front::getInstance();
        $front->addControllerDirectory(APPLICATION_PATH."/../library/App/Grid/Controller","grid")
              ->addControllerDirectory(APPLICATION_PATH."/../library/App/Module/Entities/controllers/","entitymanager");
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
    protected function _initZFDebug(){
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
    }
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
