<?php

class App_Utilitario_Form_Element_Price extends App_Utilitario_Form_Element_Abstract
{
    public function init() {
        $this->_setScript("price-element.phtml");
        parent::init();
    }
}

