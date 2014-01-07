<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

/**
 * Muestra una imagen para eliminar un elemento 
 */
class App_Utilitario_Form_Element_Delete extends App_Utilitario_Form_Element_Abstract
{
    public function init() {
        $this->_setClass($this->getAttrib("class"));
        $this->_setScript("delete.phtml");
        parent::init();
    }
}
?>
