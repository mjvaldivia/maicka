<?php

Class Zend_View_Helper_ListaArt extends App_Utilitario_Helpers{

    public function ListaArt() {
        $grid = New App_Grid2_Helper_View_Grid("letterart");
        $grid->setModel("LetterArt");
        $grid->setQuery("queryAll", array("id" => "art_id",
                                          "name" => "art_name",
                                          "letter" => "art_letter",
                                          "category" => "art_category"),
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
                "sortable" => false,
                "width" => "5%"),
            array("column_name" => "Name",
                "column_table" => array("getName"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.name"),
                "width" => "30%"),
            array("column_name" => "Letter",
                "column_table" => array("getLetter"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.letter"),
                "width" => "10%"),
            array("column_name" => "Art Category",
                "column_table" => array("getCategory", "getName"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_join" => array("p.category","categoryorder"),
                                    "sortable_field" => "categoryorder.name"),
                "width" => "30%"),
            array("column_name" => "Default",
                "column_table" => array("getDefault"),
                "column_type" => "helper",
                "column_helper" => "TicketActivo",
                "column_align" => "center",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.default"),
                "width" => "10%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a href=\"/letterart/index/edit/id/%\" class=\"btn btn-xs btn-default\">
                                    <i class=\"fa fa-pencil\"></i>
                                    Edit
                                 </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "5%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a class=\"btn btn-xs btn-red grid_delete\" table=\"letterart\" href=\"#\" url=\"/letterart/index/delete/id/%\">
                                    <i class=\"fa fa-trash-o\"></i>
                                    Delete
                                  </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "5%")
        ));


        return $grid->getGrid();
    }

}

