<?php

Class Zend_View_Helper_ListaFrame extends App_Utilitario_Helpers{

    public function ListaFrame() {
        $grid = New App_Grid2_Helper_View_Grid("frame_list");
        $grid->setModel("Frame");
        $grid->setQuery("queryAll", array("name" => "frame_name"),array());
        $grid->setColumns(array(
            array("column_name" => "Id",
                "column_table" => array("getId"),
                "column_type" => "method",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.id"),
                "width" => "25"),
            array("column_name" => "Name",
                "column_table" => array("getName"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.name"),
                "width" => "300"),
            array("column_name" => "Default",
                "column_table" => array("getDefault"),
                "column_type" => "helper",
                "column_helper" => "TicketActivo",
                "column_align" => "center",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.default"),
                "width" => "5%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a href=\"/frame/index/edit/id/%\" class=\"btn btn-xs btn-default\">
                                    <i class=\"fa fa-pencil\"></i>
                                    Edit
                                 </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "80"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a class=\"btn btn-xs btn-red grid_delete\" table=\"frame_list\" href=\"#\" url=\"/frame/index/delete/id/%\">
                                    <i class=\"fa fa-trash-o\"></i> Delete
                                  </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "80")
        ));


        return $grid->getGrid();
    }

}

