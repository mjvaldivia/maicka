<?php
Class Zend_View_Helper_ListaOrders extends App_Utilitario_Helpers{

    public function ListaOrders() {
        $grid = New App_Grid2_Helper_View_Grid("orders_list");
        $grid->setModel("OrderHeader");
        $grid->setQuery("queryAll", array("id" => "order_id",
                                          "customer" => "customer_name",
                                          "status" => "status"),
                                      array());
        $grid->setColumns(array(
            array("column_name" => "Id",
                "column_table" => array("getId"),
                "column_type" => "method",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.id"),
                "width" => "5%"),
            array("column_name" => "Date",
                "column_table" => array("getOrderDate"),
                "column_type" => "date",
                "column_align" => "left",
                "column_date" => "Y/m/d",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.order_date"),
                "width" => "10%"),
            array("column_name" => "Customer",
                  "column_table" => array("getClient","getName"),
                  "column_type" => "method",
                  "column_align" => "left",
                  "sortable" => array("active" => true,
                                      "sortable_join" => array("p.client","clientorder"),
                                      "sortable_field" => "clientorder.name"),
                  "width" => "25%"),
            array("column_name" => "Status",
                "column_table" => array("getId"),
                "column_type" => "helper",
                "column_helper" => "ColorOrderStatus",
                "column_align" => "left",
                "sortable" => array("active" => true,
                                    "sortable_join" => array("p.status","statusorder"),
                                    "sortable_field" => "statusorder.name"),
                "width" => "10%"),
            array("column_name" => "Net",
                "column_table" => array("getSubtotal"),
                "column_type" => "money",
                "column_align" => "right",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.sub_total"),
                "width" => "10%"),
            array("column_name" => "Tax",
                "column_table" => array("getTax"),
                "column_type" => "money",
                "column_align" => "right",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.tax"),
                "width" => "10%"),
            array("column_name" => "Shipping",
                "column_table" => array("getShipping"),
                "column_type" => "money",
                "column_align" => "right",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.shipping"),
                "width" => "10%"),
            array("column_name" => "Total",
                "column_table" => array("getTotal"),
                "column_type" => "money",
                "column_align" => "right",
                "sortable" => array("active" => true,
                                    "sortable_field" => "p.total"),
                "width" => "10%"),
            array("column_name" => "",
                "column_table" => array("getId"),
                "column_type" => "html",
                "column_html" => "<a href=\"/order/index/edit/id/%\" class=\"btn btn-xs btn-default\">
                                    <i class=\"fa fa-pencil\"></i>
                                    Edit Order
                                  </a>",
                "column_align" => "right",
                "sortable" => false,
                "width" => "10%")
        ));


        return $grid->getGrid();
    }

}

