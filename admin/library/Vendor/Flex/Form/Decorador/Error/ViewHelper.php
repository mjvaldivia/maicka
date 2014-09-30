<?php

class Vendor_Flex_Form_Decorador_Error_ViewHelper extends Zend_View_Helper_FormElement
{
    public function myErrorViewer($errors, array $options = null)
    {

        if (empty($options['class'])) {
            $options['class'] = 'help-block';
        }

        $start = "<span%s><i class=\"fa fa-warning\"></i> ";
        $end = "</span>";
        if (strstr($start, '%s')) {
            $start   = sprintf($start, " class='{$options['class']}'");
        }

        $html  = $start
               . array_pop($errors)
               . $end;

        return $html;
    }
}

