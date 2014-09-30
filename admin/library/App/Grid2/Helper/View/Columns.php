<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class App_Grid2_Helpers_View_Columns extends App_Utilitario_Helpers{
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    public function Columns($columns = array()){
        $this->_init();
        
        $cantidad = count($columns);
        for($i=0;$i<$cantidad;$i++){ 
            $align = "center";
            $nowrap = true;
            $sortable = "false";
            
            if(isset($columns[$i]['sortable']) AND $columns[$i]['sortable']){
                $sortable = "true";
            }
            
            if(isset($columns[$i]['column_align'])){
                $align = ($columns[$i]['column_align']) ? $columns[$i]['column_align'] : "center";
            }
            
            if(isset($columns[$i]['column_nowrap'])){
                $nowrap  = ($columns[$i]['column_nowrap'] === false) ? "false" : "true";
            }
            
            
            
            $this->_addHtml($this->view->partial("grid-column.phtml", array("column_name" => $columns[$i]['column_name'],
                                                                               //"column_table" => $columns[$i]['column_table'],
                                                                               "sortable" => $sortable,
                                                                               "align" => $align,
                                                                               "nowrap" => $nowrap,
                                                                               "width" => $columns[$i]['width'])));
            //if($i!=$cantidad-1) $this->_addHtml(",");
        
        }
        
        return $this->_getHtml();
    }
}
?>
