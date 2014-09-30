<?php

Class Zend_View_Helper_ListaMat extends App_Utilitario_Helpers{

    public function ListaMat() {
        $grid = New App_Grid2_Helper_View_Grid("mat_list");
        $grid->setModel("Mat");
        $grid->setQuery("queryAll", array("id" => "mat_id",
                                          "name" => "mat_name",
                                          "frame" => "mat_frame"),
                                      array());
        $grid->setColumns(array(
            array("column_name" => "Id",
                "column_table" => array("getId"),
                "column_type" => "method",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.id"),
                "width" => "5%"),
            array("column_name" => "Img",
                "column_table" => array("getPhoto","getUrlSmall"),
                "column_type" => "image",
                "column_align" => "left",
                "width" => "5%"),
            array("column_name" => "Name",
                "column_table" => array("getName"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.name"),
                "width" => "35%"),
            array("column_name" => "Letter Qty",
                "column_table" => array("getLetterQuantity"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.letter_quantity"),
                "width" => "10%"),
            
            array("column_name" => "Frame",
                "column_table" => array("getFrame", "getName"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_join" => array("p.frame","frameorder"),
                                    "sortable_field" => "frameorder.name"),
                "width" => "35%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a href=\"/frame/mat/edit/id/%\" class=\"btn btn-xs btn-default\">
                                    <i class=\"fa fa-pencil\"></i>
                                    Edit
                                 </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "5%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a class=\"btn btn-xs btn-red grid_delete\" table=\"mat_list\" href=\"#\" url=\"/frame/mat/delete/id/%\">
                                    <i class=\"fa fa-trash-o\"></i> Delete
                                  </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "5%")
        ));


        return $grid->getGrid();
    }

}

