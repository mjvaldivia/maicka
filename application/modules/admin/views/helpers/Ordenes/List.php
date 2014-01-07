<?php
Class Zend_View_Helper_Ordenes_List extends App_Utilitario_Helpers{
        
    public function Ordenes_List(){
        $grid = New App_Grid_Helper_Grid("ordenes");
        $grid->setModel("Orden");
        $grid->setQuery("listAll", array("id" => "ordenId",
                                         "plan" => "planId",
                                         "comprador" => "compradorId",
                                         "proveedor" => "proveedorId",
                                         "status" => "statusId"));
        $grid->setColumns(array(
                                 array("column_name" => "Id",
                                      "column_table" => array("getId"),
                                      "column_type" => "html",
                                      "column_html" => "<a class=\"button-orange\" href=\"/admin/ordenes/ver/id/%\"/> % </a>",
                                      "width" => "30"),
                                array("column_name" => "Fecha",
                                      "column_table" => "getFechaOrden",
                                      "column_type" => "date",
                                      "column_date" => "d-m-Y",
                                      "width" => "60"),
                                array("column_name" => "Plan",
                                      "column_table" => "getNombrePlan",
                                      "column_type" => "method",
                                      "width" => "160"),
                                array("column_name" => "Comprador",
                                      "column_table" => "getComprador",
                                      "column_type" => "method",
                                      "width" => "130"),
                                array("column_name" => "Status",
                                      "column_table" => array("getStatus","getName"),
                                      "column_type" => "method",
                                      "width" => "60"),                     
                                array("column_name" => "Email",
                                      "column_table" => "getEmail",
                                      "column_type" => "method",
                                      "width" => "130"),
                                array("column_name" => "Descuento",
                                      "column_table" => array("getTipoDescuento","getName"),
                                      "column_type" => "method",
                                      "width" => "80"),
                                array("column_name" => "Total",
                                      "column_table" => "getTotal",
                                      "column_type" => "money",
                                      "column_align" => "right",
                                      "width" => "80"), 
                                array("column_name" => "Eliminar",
                                      "column_table" => array("getId"),
                                      "column_type" => "html",
                                      "sortable" => false,
                                      "column_align" => "left",
                                      "column_html" => "
                                                        <a class=\"grid_delete\" table=\"ordenes\" indice=\"%\" href=\"/admin/ordenes/delete/id/%\">
                                                          <span class=\"icon icon-color icon-trash\" rel=\"tooltip\" title=\"Borrar orden\"></span>
                                                        </a>",
                                      "width" => "50"),
                                      
                               )
                         );
        
        return $grid->getGrid();
    }
}
?>
