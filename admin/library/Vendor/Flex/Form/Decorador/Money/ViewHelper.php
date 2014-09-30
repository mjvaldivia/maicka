<?php

class Vendor_Flex_Form_Decorador_Money_ViewHelper extends Zend_View_Helper_FormElement
{
    public function mySimbolViewer(array $options = null)
    {

        return "<span class=\"input-group-addon\">$</span>";
    }
}

