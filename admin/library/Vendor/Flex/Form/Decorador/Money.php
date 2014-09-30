<?php

class Vendor_Flex_Form_Decorador_Money extends Zend_Form_Decorator_Abstract
{
    public function render($content)
     {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        
        $viewhelp = new Vendor_Flex_Form_Decorador_Money_ViewHelper();
        $simbol = $viewhelp->mySimbolViewer($this->getOptions());

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $simbol;
            case self::PREPEND:
                return $simbol . $separator . $content;
        }
     }

}

