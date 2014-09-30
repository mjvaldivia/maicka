<?php

class Helper_Pdf extends Zend_Controller_Action_Helper_Abstract{
    
    /**
     * Abre el PDF
     * @param int $id_order
     */
    public function open($id_order){
        $this->_actionController->getHelper("layout")->disableLayout();
        $this->_actionController->getHelper("viewRenderer")->setNoRender(true);

        $livedocx = New Admin_Order_Pdf($id_order);
        $livedocx->open(APPLICATION_PATH . "/../public/upload/order-".$id_order.".pdf", 
                        "order-" . $id_order . ".pdf");
    }
}

