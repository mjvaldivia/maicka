<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class App_Grid_Helper_Grid{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    /**
     * @var Zend_Cache 
     */
    protected $_cache;
    
    /**
     * Titulo de la tabla
     * @var string 
     */
    protected $_title;
    
    /**
     * Querybuilder
     * @var querybuilder 
     */
    protected $_queryBuilder;
    
    /**
     * Modelo
     * @var type 
     */
    protected $_model;
    
    /**
     * Configuracion de columna
     * @var array 
     */
    protected $_columns;
    
    /**
     * @var Zend View 
     */
    protected $_view;
    
    /**
     * Constructor
     * @param type $title 
     */
    public function __construct($title) {
        $this->_title = $title;
        $this->_view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $this->_view->addHelperPath(APPLICATION_PATH.'/../library/App/Grid/Helper/', 'App_Grid_Helpers');
        $this->_cache = App_Cache_Set::cacheEterno(); 
    }
    
    /**
     * Setea la consulta
     * @param type $query 
     */
    public function setQuery($query, $params = array(), $fixed = array()){
        $this->_queryBuilder = array("method" => $query,
                                     "params" => $params,
                                     "fixed"  => $fixed);
    }
    
    /**
     * Setea el modelo
     * @param string $model 
     */
    public function setModel($model){
        $this->_model = $model;
    }
    
    /**
     *
     * @param array $columns array(
     *                              array("column_name" => "",
     *                                    "column_table" => "",
     *                                    "width" => "")
     *                              )  
     */
    public function setColumns($columns){
        $this->_columns = $columns;
    }
    
    /**
     * Devuelve el HTML de la grilla 
     */
    public function getGrid(){
        $this->_addViewFiles();
        
        $width = 0;
        foreach($this->_columns as $key => $value){
            $width = $width + $value['width'];
        }
        
        $request = Zend_Controller_Front::getInstance()->getRequest();

        if(!$request->isXmlHttpRequest()){
            $this->_view->headScript()->appendScript($this->_view->partial("grid-js.phtml",array("title" => $this->_title,
                                                                                                 "columns" => $this->_columns,
                                                                                                 "width" => $width,
                                                                                                 "params" => $this->_getParams())));
        } else {
            $html .= "<script>" . $this->_view->partial("grid-js.phtml",array("title" => $this->_title,
                                                                                                 "columns" => $this->_columns,
                                                                                                 "width" => $width,
                                                                                                 "params" => $this->_getParams())) . "</script>";
        }
        
        $html = $this->_view->partial("grid.phtml", array("title" => $this->_title));
        
        $data = array("title"   => $this->_title,
                      "url"     => $this->_getUrl(),
                      "columns" => $this->_columns,
                      "model" => $this->_model,
                      "query" => $this->_queryBuilder);
        
        $this->_cache->save($data, $this->_title);
        
        return $html;
        
    }
    
    /**
     * 
     */
    protected function _getUrl(){
        $request = Zend_Controller_Front::getInstance()->getRequest();
        return "/" . $request->getModuleName() . "/" . $request->getControllerName() . "/";
    }
    
    /**
     * Genera los parametros
     * @return string
     */
    protected function _getParams(){
        $params = "";
        foreach($this->_queryBuilder['params'] as $key => $value){
            $params .= "/" . $value . "/' + $('#" . $value . "').val() + '";
        }
        return $params;
    }
    
    /**
     * Añade los archivos de Js y Css de flexgrid 
     */
    protected function _addViewFiles(){
        $this->_view->headScript()->appendFile('/flexgrid/flexigrid.js', 'text/javascript');
        $this->_view->headScript()->appendFile('/flexgrid/functions.js', 'text/javascript');
        $this->_view->headScript()->appendFile('/admin/js/jquery.cookie.js', 'text/javascript');
        $this->_view->headLink()->appendStylesheet("/flexgrid/flexigrid.css");
        $this->_view->addBasePath($this->_DIR . "/view");
    }
}
?>
