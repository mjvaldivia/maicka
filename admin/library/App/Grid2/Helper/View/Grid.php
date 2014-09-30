<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class App_Grid2_Helper_View_Grid{

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
     * Indica si se usa alias en el select. Cuando se usa addSelect() en el query.
     * @var boolean
     */
    protected $_useAliasSelect = false;

    /**
     * Ruta a helpers
     * @var array
     */
    protected $_helpers;

    /**
     * Agrega vistas
     * @var array
     */
    protected $_base_views;

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
        $this->_view->addHelperPath(APPLICATION_PATH.'/../library/App/Grid2/Helper/View', 'App_Grid2_Helpers_View');
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
        $html = "";
        $this->_addViewFiles();

        $columns = "";
        foreach($this->_columns as $key => $value){
            $columns .= "{";
            if(isset($value['sortable']) and $value['sortable']["active"]){
                $columns .= "\"orderable\": true,";
            } else {
                $columns .= "\"orderable\": false, ";
            }
            
            
            if(isset($value['column_align'])){
                switch ($value['column_align']) {
                    case "right":
                        $columns .= " className: \"text-right\",";
                        break;
                    case "center":
                        $columns .= " className: \"text-center\",";
                        break;
                    default:
                        $columns .= " className: \"text-left\",";
                        break;
                }
                
            }
            
            $columns .= "},";
        }
        $columns .= "";

        $request = Zend_Controller_Front::getInstance()->getRequest();

        if(!$request->isXmlHttpRequest()){
            $this->_view->headScript()->appendScript($this->_view->partial("grid-js.phtml",array("title" => $this->_title,
                                                                                                 "columns" => $columns,
                                                                                                 
                                                                                                 "params" => $this->_getParams())));
        } else {
            $html .= "<script>" . $this->_view->partial("grid-js.phtml",array("title" => $this->_title,
                                                                                "columns" => $columns,
                                                                              
                                                                                "params" => $this->_getParams())) . "</script>";
        }

        $html .= $this->_view->partial("grid.phtml", array("title" => $this->_title,
                                                           "columns" => $this->_columns));

        $data = array("title" => $this->_title,
                      "columns" => $this->_columns,
                      "helpers" => $this->_helpers,
                      "views" => $this->_base_views,
                      "model" => $this->_model,
                      "query" => $this->_queryBuilder,
                     );

        $this->_cache->save($data, $this->_title);
        return $html;
    }

    /**
     * Setea los helpers
     * @param type $ruta
     * @param type $namespace
     */
    public function addHelperPath($ruta, $namespace){
        $this->_helpers[] = array("ruta" => $ruta,
                                  "namespace" => $namespace);
    }

    /**
     * Agrega una vista base
     * @param type $ruta
     */
    public function addViewBasePath($ruta){
        $this->_base_views[] = $ruta;
    }

    /**
     * @return string
     */
    protected function _getParams(){
        $params = "";
        foreach($this->_queryBuilder['params'] as $key => $value){
            $params .= "d." . $value . " = $('#" . $value . "').val();\n";
        }
        return $params;
    }

    /**
     * Añade los archivos de Js y Css de flexgrid
     */
    protected function _addViewFiles(){
        $this->_view->headScript()->appendFile('/js/plugins/datatables/jquery.dataTables.min.js', 'text/javascript')
                                  ->appendFile('/js/plugins/datatables/datatables-bs3.js', 'text/javascript');
        $this->_view->headLink()->appendStylesheet("/css/plugins/datatables/datatables.css", "screen");
        $this->_view->addBasePath($this->_DIR . "/views");
    }

}
?>
