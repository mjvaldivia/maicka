<?php


Class Zend_View_Helper_ListaCompanies extends App_Utilitario_Helpers{

    public function ListaCompanies() {
        $grid = New App_Grid2_Helper_View_Grid("shipping_companies");
        $grid->setModel("ShippingCompany");
        $grid->setQuery("queryAll", array("name" => "company_name"),array());
        $grid->setColumns(array(
            array("column_name" => "Id",
                "column_table" => array("getId"),
                "column_type" => "method",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.id"),
                "width" => "10%"),
            array("column_name" => "Name",
                "column_table" => array("getName"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.name"),
                "width" => "40%"),
            array("column_name" => "Url",
                "column_table" => array("getTrackUrl"),
                "column_type" => "method",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.track_url"),
                "width" => "30%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a href=\"/shipping/companies/edit/id/%\" class=\"btn btn-xs btn-default\">
                                    <i class=\"fa fa-pencil\"></i>
                                    Edit
                                 </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "10%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a class=\"btn btn-xs btn-red grid_delete\" table=\"shipping_companies\" href=\"#\" url=\"/shipping/companies/delete/id/%\">
                                    <i class=\"fa fa-trash-o\"></i> Delete
                                  </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "10%")
        ));


        return $grid->getGrid();
    }

}

