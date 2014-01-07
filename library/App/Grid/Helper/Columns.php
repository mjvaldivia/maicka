<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class App_Grid_Helpers_Columns extends App_Utilitario_Helpers{
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    public function Columns($columns = array()){
        $this->_init();
        
        $cantidad = count($columns);
        for($i=0;$i<$cantidad;$i++){     
            
            if(isset($columns[$i]['column_align'])){
                $column_align = $columns[$i]['column_align'];
            } else {
                $column_align = "center";
            }
            
            $this->_addHtml($this->view->partial("grid-column-js.phtml", array("column_name" => $columns[$i]['column_name'],
                                                                               "column_table" => $columns[$i]['column_table'],
                                                                               "column_align" => $column_align,
                                                                               "width" => $columns[$i]['width'])));
            if($i!=$cantidad-1) $this->_addHtml(",");
        
        }
        
        return $this->_getHtml();
    }
}
?>
