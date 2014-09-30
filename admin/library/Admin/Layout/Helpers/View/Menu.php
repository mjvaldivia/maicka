<?php

/**
 * Genera el menu izquierdo
 * para el admin
 */
Class Admin_View_Helper_Menu extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    protected $_request;
    
    protected $_module;
    
    protected $_controller;
    
    /**
     * Paginas del menu
     * @var array 
     */
    protected $_paginas = array("Dashboard" => array("icon_class" => "fa-dashboard",
                                                     "module" => "default",
                                                     "controller" => "index",
                                                     "child" => array()),
        
                                "Image Gallery" => array("icon_class" => "fa-picture-o",
                                                         "module" => "imagegallery",
                                                         "controller" => "index",
                                                         "child" => array()),
        
                                "Orders" => array("icon_class" => "fa-shopping-cart",
                                                  "child" => array("List" => array("module" => "order",
                                                                                    "controller" => array("index", 
                                                                                                           // Sub-paginas
                                                                                                          "address-bill",
                                                                                                          "address-ship")),
                                                                   )),   
                                "Shipping" => array("icon_class" => "fa-truck",
                                                 "child" => array("Pricing" => array("module" => "shipping",
                                                                                     "controller" => "price"),
                                                                  "Companies" => array("module" => "shipping",
                                                                                       "controller" => "companies"))),
                                "Customers" => array("icon_class" => "fa-group",
                                                    "child" => array("List" => array("module" => "customer",
                                                                                     "controller" => "index"))),
                                "Letter" => array("icon_class" => "fa-font",
                                                  "child" => array("Art" => array("module" => "letterart",
                                                                                  "controller" => "index"),
                                                                   "Category" => array("module" => "letterart",
                                                                                       "controller" => "category"))),
                                
                                "Frame" => array("icon_class" => "fa-square-o",
                                                 "child" => array("Master" => array("module" => "frame",
                                                                                        "controller" => "index"),
                                                                   "Mat" => array("module" => "frame",
                                                                                  "controller" => "mat"))),
        
                                "Item" => array("icon_class" => "fa-lemon-o",
                                                 "child" => array("Master" => array("module" => "item",
                                                                                  "controller" => "index"))),
                                                                                
                                
                                );
    
    
    /**
     * Genera el menu izquierdo
     */
    public function Menu(){
        $this->_init();
        $this->_request = Zend_Controller_Front::getInstance()->getRequest();
        
        $this->_module = $this->_request->getModuleName();
        $this->_controller = $this->_request->getControllerName();
        
        foreach($this->_paginas as $name => $datos){
            if(count($datos['child'])>0){
                $target = strtolower(str_replace(" ", "", $name));
                
                $child = $this->_listChildren($datos['child']);
                
                $class = "";
                if($child['active']){
                    $class = "in";
                }
                
                
                $this->_addHtml($this->view->partial("menu-header-child.phtml", 
                                                  array("icon_class" => $datos['icon_class'],
                                                        "name" => $name,
                                                        "class" => $class,
                                                        "target" => $target,
                                                        "child" => $child['html'])));
            }else{
                
                if(is_array($datos['controller'])){
                    $controller = $datos['controller'][0];
                } else {
                    $controller = $datos['controller'];
                }
                
                $this->_addHtml($this->view->partial("menu-header.phtml", 
                                                  array("icon_class" => $datos['icon_class'],
                                                        "name" => $name,
                                                        "url"  => "/" . $datos['module'] . "/" . $controller)));
        
            }
        }
        
        return $this->_getHtml();
    }
    
    /**
     * Lista los hijos del menu
     * @param array $paginas
     * @return string html
     */
    protected function _listChildren($paginas){
        $html = "";
        $active = false;
        if(count($paginas)>0){
            foreach($paginas as $name => $datos){
                $class = "";
                
                if(is_array($datos['controller'])){
                    if($this->_module == $datos['module'] AND in_array($this->_controller , $datos['controller'])){
                        $class = "active";
                        $active = true;
                    }
                    $controller = $datos['controller'][0];
                } else {
                    if($this->_module == $datos['module'] AND $this->_controller == $datos['controller']){
                        $class = "active";
                        $active = true;
                    }
                    $controller = $datos['controller'];
                }
                
                $html .= $this->view->partial("menu-item.phtml", array("name" => $name,
                                                                       "class" => $class,
                                                                       "url" => "/" . $datos['module'] . "/" . $controller));
            }
        }
        return array("html" => $html,
                     "active" => $active);
    }
}

