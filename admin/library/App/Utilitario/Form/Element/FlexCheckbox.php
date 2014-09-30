<?php

class App_Utilitario_Form_Element_FlexCheckbox extends App_Utilitario_Form_Element_Abstract
{
    public function init() {
        $this->_setScript("flex-checkbox.phtml");
        parent::init();
    }
}

