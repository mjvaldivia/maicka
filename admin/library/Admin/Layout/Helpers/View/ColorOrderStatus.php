<?php

/**
 * Colorea el nombre del status con un colo especifico.
 * Para cada tipo de status
 */
Class Admin_View_Helper_ColorOrderStatus extends App_Utilitario_Helpers{
    
    /**
     * 
     * @param \Model\Entity\OrderHeader $order_header
     */
    public function ColorOrderStatus($order_header){
        $status = $order_header->getStatus();
        switch ($status->getId()) {
            case 1:
                $button = "btn-green";
                break;
            case 2:
                $button = "btn-blue";
                break;
            case 3:
                $button = "btn-info";
                break;
            case 4:
                $button = "btn-orange";
                break;
            case 5:
                $button = "btn-purple";
                break;
            case 6:
                $button = "btn-success";
                break;
            case 7:
                $button = "btn-default disabled";
                break;
            default:
                break;
        }
        
        return "<span class=\"btn btn-xs " . $button . "\"> " . $status->getName() . " </span>";
    }
}

