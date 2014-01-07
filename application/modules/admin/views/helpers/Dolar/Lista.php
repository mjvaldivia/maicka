<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Dolar_Lista extends App_Utilitario_Helpers{


    public function Dolar_Lista() {
        $grid = New App_Grid_Helper_Grid("dolar");
        $grid->setModel("Dolar");
        $grid->setQuery("listAll", array("fecha" => "fecha"));
 

        $grid->setColumns(array(
            array("column_name" => "Actions",
                "column_table" => array("getId"),
                "column_type" => "html",
                "sortable" => false,
                "column_align" => "left",
                "column_html" => "<a href=\"/admin/dolar/edit/id/%\">
                                    <span class=\"icon icon-color icon-compose\" rel=\"tooltip\" title=\"Editar dolar\"></span>
                                  </a>
                                  &nbsp;&nbsp;
                                  <a class=\"grid_delete\" table=\"dolar\" indice=\"%\" href=\"/admin/dolar/delete/id/%\">
                                    <span class=\"icon icon-color icon-trash\" rel=\"tooltip\" title=\"Borrar dolar\"></span>
                                  </a>",
                "width" => "50"),
           array("column_name" => "Fecha Inicio",
                "column_table" => "getFechaInicio",
                "column_type" => "method",
                "width" => "100"),
          array("column_name" => "Fecha Termino",
                "column_table" => "getFechaTermino",
                "column_type" => "method",
                "width" => "100"),
          array("column_name" => "Valor del Dolar en CLP",
                "column_table" => "getMoneda",
                "column_type" => "money",
                "width" => "130"),
            
        ));
        
        return $grid->getGrid();
    }
   
    
}
?>
