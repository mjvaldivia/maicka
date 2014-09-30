<?php

Class Zend_View_Helper_ListaPrice extends App_Utilitario_Helpers{

    public function ListaPrice() {
        $grid = New App_Grid2_Helper_View_Grid("shipping_price_list");
        $grid->setModel("Shipping");
        $grid->setQuery("queryAll", array("country" => "country_name"),array());
        $grid->setColumns(array(
            array("column_name" => "Id",
                "column_table" => array("getId"),
                "column_type" => "method",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.id"),
                "width" => "10%"),
            array("column_name" => "Country",
                "column_table" => array("getCountry", "getName"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_join" => array("p.country","countryorder"),
                                    "sortable_field" => "countryorder.name"),
                "width" => "40%"),
            array("column_name" => "Price",
                "column_table" => array("getPrice"),
                "column_type" => "money",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.price"),
                "width" => "30%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a href=\"/shipping/price/edit/id/%\" class=\"btn btn-xs btn-default\">
                                    <i class=\"fa fa-pencil\"></i>
                                    Edit
                                 </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "10%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a class=\"btn btn-xs btn-red grid_delete\" table=\"shipping_price_list\" href=\"#\" url=\"/shipping/price/delete/id/%\">
                                    <i class=\"fa fa-trash-o\"></i> Delete
                                  </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "10%")
        ));


        return $grid->getGrid();
    }

}

