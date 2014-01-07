<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Proveedor_Lista extends App_Utilitario_Helpers{


    public function Proveedor_Lista() {
        $grid = New App_Grid_Helper_Grid("proveedor");
        
        $grid->setModel("Proveedor");
        $grid->setQuery("listAll", array("name" => "proveedor_name", 
                                         "active" => "proveedor_active"));
 

        $grid->setColumns(array(
            array("column_name" => "Actions",
                "column_table" => array("getId"),
                "column_type" => "html",
                "sortable" => false,
                "column_align" => "left",
                "column_html" => "<a href=\"/admin/proveedor/edit/id/%\">
                                    <span class=\"icon icon-color icon-compose\" rel=\"tooltip\" title=\"Editar proveedor\"></span>
                                  </a>
                                  &nbsp;&nbsp;
                                  <a class=\"grid_delete\" table=\"proveedor\" indice=\"%\" href=\"/admin/proveedor/delete/id/%\">
                                    <span class=\"icon icon-color icon-trash\" rel=\"tooltip\" title=\"Borrar proveedor\"></span>
                                  </a>",
                "width" => "50"),
            array("column_name" => "Estado",
                  "column_table" => array("getActive"),
                  "column_type" => "active",
                  "column_get" => "getActive",
                  "column_set" => "setActive",
                  "width" => "80"),
            array("column_name" => "Imagen",
                  "column_table" => array("getImgPath"),
                  "column_type" => "html",
                  "column_html" => "<img src=\"%\" width=\"100px\">",
                  "width" => "105"),
            array("column_name" => "Nombre",
                  "column_table" => "getName",
                  "column_type" => "method",
                  "width" => "300"),
            array("column_name" => "Planes",
                  "column_table" => array("getId"),
                  "column_type" => "html",
                  "column_html" => "<a class=\"button-orange\" href=\"/admin/plan/index/proveedor/%\"/><img title=\"Ir a planes\" src=\"/images/icons/arrow-right.png\" /> </a>",
                  "width" => "60")
            
        ));
        
        return $grid->getGrid();
    }
   
    
}
?>
