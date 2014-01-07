<?php

class App_Utilitario_Form_Element_Video extends App_Utilitario_Form_Element_Abstract
{
    public function init() {
        $this->_setScript("video-element.phtml");
        parent::init();
    }
    
    public function setValue($value) {
        parent::setValue($value);
    }
}

?>
