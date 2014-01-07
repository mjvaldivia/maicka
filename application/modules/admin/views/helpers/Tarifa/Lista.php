<?php
/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Tarifa_Lista extends App_Utilitario_Helpers{
    public function Tarifa_Lista($id_plan) {
        $grid = New App_Grid_Helper_Grid("tarifas");
        $grid->setModel("Tarifa");
        $grid->setQuery("listAll", array("dias" => "dia"),
                                   array("plan" => $id_plan));
        $grid->setColumns(array(
                         array("column_name" => "Actions",
                                "column_table" => array("getId"),
                                "column_type" => "html",
                                "sortable" => false,
                                "column_align" => "left",
                                "column_html" => "<a href=\"/admin/tarifa/edit/id/%/plan/".$id_plan."\">
                                                    <span class=\"icon icon-color icon-compose\" rel=\"tooltip\" title=\"Editar tarifa\"></span>
                                                  </a>
                                                  &nbsp;&nbsp;
                                                  <a class=\"grid_delete\" table=\"tarifas\" indice=\"%\" href=\"/admin/tarifa/delete/id/%/plan/".$id_plan."\">
                                                    <span class=\"icon icon-color icon-trash\" rel=\"tooltip\" title=\"Eliminar tarifa\"></span>
                                                  </a>",
                                "width" => "50"),
                        array("column_name" => "Desde",
                                "column_table" => "getdiasDesde",
                                "column_type" => "method",
                                "width" => "100"),
                        array("column_name" => "Hasta",
                                "column_table" => "getdiasHasta",
                                "column_type" => "method",
                                "width" => "100"),
                        array("column_name" => "Valor",
                                "column_table" => "getPrecio",
                                "column_type" => "money",
                                "width" => "70")
                         )
                );
        return $grid->getGrid();
    }
   
    
}
?>
