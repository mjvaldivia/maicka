<?php

Class Admin_View_Helper_TicketActivo extends App_Utilitario_Helpers{
    
    /**
     * 
     * @param \Model\Entity\XXXXX $row
     * @param boolean $row
     */
    public function TicketActivo($row, $valor){
        if($valor){
            return "<i class=\"fa fa-check\"></i>";
        } else {
            return "<i class=\"fa fa-times\"></i>";
        }
    }
}

