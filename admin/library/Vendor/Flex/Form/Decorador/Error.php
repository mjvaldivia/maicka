<?php

class Vendor_Flex_Form_Decorador_Error extends Zend_Form_Decorator_Abstract
{
    public function render($content)
     {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $errors = $element->getMessages();
        if (empty($errors)) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $viewhelp = new Vendor_Flex_Form_Decorador_Error_ViewHelper();
        $errors = $viewhelp->myErrorViewer($errors, $this->getOptions());

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $errors;
            case self::PREPEND:
                return $errors . $separator . $content;
        }
     }

}

