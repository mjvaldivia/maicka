<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class App_Utilitario_Form_Element_DivEnd extends App_Utilitario_Form_Element_Abstract
{
    public function init() {
        $this->_setScript("div-end.phtml");
        parent::init();
    }
}
?>
