<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Grid_View_Helper_Active extends App_Utilitario_Helpers{
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    
    public function Active($item, $value, $name, $url, $key = 0){
        $this->_init();
        
        if($value){
            $class = "label-success grid_active_deactive";
            $text  = "Activo";
        } else {
            $class = "grid_active_deactive";
            $text = "Inactivo";
        }
        
        return $this->view->partial("grid-active.phtml", array("id"  => $item->getId(),
                                                               "url" => $url,
                                                               "table_name" => $name,
                                                               "columna" => $key,
                                                               "class" => $class,
                                                               "text" => $text));
        
    }
}
?>
