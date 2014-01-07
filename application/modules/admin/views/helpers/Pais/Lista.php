<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Pais_Lista extends App_Utilitario_Helpers{


    public function Pais_Lista() {
        $grid = New App_Grid_Helper_Grid("pais");
        $grid->setModel("Pais");
        $grid->setQuery("queryListAll", array("name" => "pais_name", 
                                         "active" => "pais_active"));
 

        $grid->setColumns(array(
            array("column_name" => "Actions",
                "column_table" => array("getId"),
                "column_type" => "html",
                "sortable" => false,
                "column_align" => "left",
                "column_html" => "<a href=\"/admin/paises/edit/id/%\">
                                    <span class=\"icon icon-color icon-compose\" rel=\"tooltip\" title=\"Editar pais\"></span>
                                  </a>
                                  &nbsp;&nbsp;
                                  <a class=\"grid_delete\" table=\"pais\" indice=\"%\" href=\"/admin/paises/delete/id/%\">
                                    <span class=\"icon icon-color icon-trash\" rel=\"tooltip\" title=\"Borrar pais\"></span>
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
