<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

/**
 * Inicia un DIV
 */
class App_Utilitario_Form_Element_DivStart extends App_Utilitario_Form_Element_Abstract
{
    public function init() {
        $this->_setClass($this->getAttrib("class"));
        $this->_setScript("div-start.phtml");
        parent::init();
    }
}
?>


