<?php
/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Plan_Lista extends App_Utilitario_Helpers{
    public function Plan_Lista($id_proveedor) {        
        $grid = New App_Grid_Helper_Grid("plan");
        
        $grid->setModel("Plan");
        $grid->setQuery("listAll", array("name" => "plan_name", 
                                         "active" => "plan_active"),
                                   array("proveedor" => $id_proveedor));
        
        $grid->setColumns(array(
                                array("column_name" => "Actions",
                                      "column_table" => array("getId"),
                                      "column_type" => "html",
                                      "sortable" => false,
                                      "column_align" => "left",
                                      "column_html" => "<a href=\"/admin/plan/edit/id/%/proveedor/".$id_proveedor."\">
                                                            <span class=\"icon icon-color icon-compose\" rel=\"tooltip\" title=\"Editar plan\"></span>
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <a class=\"grid_delete\" table=\"plan\" indice=\"%\" href=\"/admin/plan/delete/id/%/proveedor/".$id_proveedor."\">
                                                            <span class=\"icon icon-color icon-trash\" rel=\"tooltip\" title=\"Borrar plan\"></span>
                                                        </a>",
                                      "width" => "50"),
                                array("column_name" => "Estado",
                                      "column_table" => array("getActive"),
                                      "column_type" => "active",
                                      "column_get" => "getActive",
                                      "column_set" => "setActive",
                                      "width" => "80"),
                                array("column_name" => "Name",
                                      "column_table" => "getName",
                                      "column_type" => "method",
                                      "width" => "250"),
                                array("column_name" => "Sobrecargo",
                                      "column_table" => "getSobrecargo",
                                      "column_type" => "method",
                                      "width" => "40"),
                                array("column_name" => "Edad maxima",
                                      "column_table" => "getEdadMaxima",
                                      "column_type" => "method",
                                      "width" => "40"),
                                array("column_name" => "Detalle",
                                      "column_table" => "getDetalleDescripcion",
                                      "column_type" => "method",
                                      "width" => "200"),
                                array("column_name" => "Tarifas",
                                      "column_table" => array("getId"),
                                      "column_type" => "html",
                                      "column_html" => "<a class=\"button-orange\" href=\"/admin/tarifa/index/plan/%\"/> <img title=\"Ir a tarifas\" src=\"/images/icons/arrow-right.png\" /> </a>",
                                      "width" => "40")
                                
                               )
                         );
        
        

        
        return $grid->getGrid();
    }
   
    
}
?>
