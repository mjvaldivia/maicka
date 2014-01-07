<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Motivo_Lista extends App_Utilitario_Helpers{


    public function Motivo_Lista() {
        $grid = New App_Grid_Helper_Grid("motivo");
        $grid->setModel("MotivoViaje");
        $grid->setQuery("queryListAll", array("name" => "motivo_name", 
                                         "active" => "motivo_active"));
 

        $grid->setColumns(array(
            array("column_name" => "Actions",
                "column_table" => array("getId"),
                "column_type" => "html",
                "sortable" => false,
                "column_align" => "left",
                "column_html" => "<a href=\"/admin/motivos/edit/id/%\">
                                    <span class=\"icon icon-color icon-compose\" rel=\"tooltip\" title=\"Editar motivo\"></span>
                                  </a>
                                  &nbsp;&nbsp;
                                  <a class=\"grid_delete\" table=\"motivo\" indice=\"%\" href=\"/admin/motivos/delete/id/%\">
                                    <span class=\"icon icon-color icon-trash\" rel=\"tooltip\" title=\"Borrar motivo\"></span>
                                  </a>",
                "width" => "50"),
            array("column_name" => "Estado",
                  "column_table" => array("getActive"),
                  "column_type" => "active",
                  "column_get" => "getActive",
                  "column_set" => "setActive",
                  "width" => "80"),

            array("column_name" => "Nombre",
                  "column_table" => "getName",
                  "column_type" => "method",
                  "width" => "300")
            
        ));
        
        return $grid->getGrid();
    }
   
    
}
?>
