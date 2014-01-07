<?php
class App_Utilitario_Form_Element_Archivo extends App_Utilitario_Form_Element_Abstract
{
    public function init() {
        $this->_setScript("file-element.phtml");
        parent::init();
    }
}
?>

