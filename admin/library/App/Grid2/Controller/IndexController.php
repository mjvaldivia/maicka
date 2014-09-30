<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Grid2_IndexController extends Zend_Controller_Action{
    
    public $ajaxable = array("active-deactive" => array("json"));
    
    /**
     * Nombre de la tabla
     * @var string 
     */
    protected $_title;
    
    /**
     * Datos guardados en cache
     * @var array 
     */
    protected $_data;
    
    /**
     * Inicia la vista 
     */
    public function init() {
        $this ->_helper->getHelper('AjaxContext')->initContext();
        # We don't want to render Layout
        $this->_helper->layout()->disableLayout();

        # rendering view is also not necessary
        $this->_helper->viewRenderer->setNoRender();
    }
    
    /**
     * Lista los datos en JSON
     */ 
    public function listAction(){

        $req = $this->getRequest();
        
        $title = $req->getParam("name");
        $this->_title = $title;
        $cache = App_Cache_Set::cacheEterno(); 
        if(($this->_data = $cache->load($title)) === false){
            
        } else {
            
            # Pagination parameters
            $start 	= $req->getPost('start', 1);
            $resultsPerPage = $req->getPost('length', 10);
            
            $query = $this->_getQuery();
            
            $total = $this->_getTotal();
            
            $query->setMaxResults($resultsPerPage)
                  ->setFirstResult($start);
            
            $order = $req->getPost("order");
            $order_column = $order[0]['column'];
           
            if($order[0]['dir'] == "desc"){
                $direccion = "desc";
            } else {
                $direccion = "asc";
            }
            
            if(isset($this->_data['columns'][$order_column]['sortable']) && $this->_data['columns'][$order_column]['sortable']['active']){
                if(isset($this->_data['columns'][$order_column]['sortable']['sortable_join'])){
                    $query->leftJoin($this->_data['columns'][$order_column]['sortable']['sortable_join'][0],$this->_data['columns'][$order_column]['sortable']['sortable_join'][1]);
                }
                $query->orderBy($this->_data['columns'][$order_column]['sortable']['sortable_field'], $direccion);
            }
            
            
            $list = $query->getQuery()->getResult();
            
            $elements = array();
            # We also have to format our data array that flexifrid could retrieve itt
            foreach($list as $item){
                $elements[] = $this->_getDataColumn($item);
            }

            echo Zend_Json::encode(array(
                'draw' => $this->_getParam("draw"),
                'recordsTotal'	=> $total,
                'recordsFiltered' => $total,
                'data'	=>	$elements
            ));
        }

    }
    
     /**
     * Activa o desactiva un campo boolean
     */
    public function activeDeactiveAction(){

        $this->_title = $this->_getParam("name");
        $cache = App_Cache_Set::cacheEterno();
       // fb("entrando");
        if(($this->_data = $cache->load($this->_title)) === false){
            
        } else {
            $entity_manager = App_Doctrine_Repository::entityManager();
            
            $numero_columna = (int) $this->_getParam("column");
            
            $model_repository = App_Doctrine_Repository::repository($this->_data['model']);
            $model = $model_repository->findOneBy(array("id" => $this->_getParam("id")));
            
            if($model){
               $columna = $this->_data['columns'][$numero_columna];
               fb($columna);
               
               $activo = !$model->{$columna['column_get']}();
               $model->{$columna['column_set']}($activo);
               
               $entity_manager->persist($model);
               $entity_manager->flush();
               
               $this->view->result = $activo;
            }
        }
    }
    
    /**
     * Ejecuta la consulta
     * @return Doctrine_Query 
     */
     protected function _getQuery(){
        $req = $this->getRequest();
        $model = App_Doctrine_Repository::repository($this->_data['model']);

        $params = array();
        $busqueda = array();
        foreach($this->_data['query']['params'] as $key => $value){
            $params[$key] = $req->getParam($value);
            $busqueda[$value] = $req->getParam($value);
        }
        
        $session = new Zend_Session_Namespace("search");
        $session->{$this->_title} = $busqueda;

        foreach($this->_data['query']['fixed'] as $key => $value){
            $params[$key] = $value;
        }

        $query  = $model->{$this->_data['query']['method']}($params);

        return $query;
    }
    
    /**
     * Devuelve la cantidad total de resultados
     * @return int 
     */
    protected function _getTotal(){
        $query = $this->_getQuery();
        $total = $query->resetDQLPart('select')
                     ->select('COUNT(p)')
                     ->getQuery()
                     ->getSingleScalarResult();
        return $total;
    }
    
    /**
     * Muestra el dato de la columna
     * @param /Model/Entity/xxxx $item
     * @return array 
     */
    protected function _getDataColumn($item){
        $salida = array();
        foreach($this->_data['columns'] as $key => $value){
            
            if(is_array($value['column_table'])){
                $obj = $item;
                foreach($value['column_table'] as $i => $metodo){
                    if(method_exists($obj, $metodo) and $obj){
                        $obj = $obj->{$metodo}();
                    } 
                }
                $valor = $obj;
                /*if(!is_object($obj)) $valor = $obj;
                else $valor = "";*/
                
            } else {
                $valor = $item->{$value['column_table']}();
            }
            
            switch ($value['column_type']){
                case "image":
                    if(is_file(APPLICATION_PATH . "/../public".$valor)){
                        $salida[] = "<img src=\"".$valor."\" class=\"img-table\" />";
                    } else $salida[] = "<img src=\"/img/no-image.png\" class=\"img-table\" />";;
                    break;
                case "active":
                    //fb($key);
                    $html = $this->view->Active($item, $valor, $this->_title,  $key);
                    $salida[] = $html;
                    break;
                case "helper":
                    $html = $this->view->{$value['column_helper']}($item, $valor, $this->_title);
                    $salida[] = $html;
                    break;
                case "html":
                    $html = $value['column_html'];
                    $salida[] = str_replace("%", $valor, $html);
                    break;
                case "date":
                    //fb($valor->format("y-m-d"));
                    if($valor instanceof DateTime ){
                       
                       $salida[] = $valor->format($value['column_date']);
                    } else{
                       $salida[] = "";
                    }
                    break;
                case "money":
                    
                    
                    
                    if(!is_numeric($valor)){
                        fb(__METHOD__ . " Valor no numerico ".$valor);
                        $valor = 0;
                    }
                    
                    $currency = new Zend_Currency(
                                                    array(
                                                        'value' => $valor,
                                                    )
                                                );
                    $currency->setFormat(array("precision" => 2));
                    
                   
                    $salida[] = $currency->toCurrency();
                   
                    break;
                default:
                    $salida[] = $valor;
                    break;
            }
      
        }
        return $salida;
    }

    
}
?>
