<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class Zend_View_Helper_Mensaje extends App_Utilitario_Helpers{ 
    
    /**
     * Directorio actual
     * @var type 
     */
    protected $_DIR = __DIR__;
    
    public function Mensaje($error){
        $this->_init();
        if($error){
            return "<div class=\"alert alert-danger\">
                        <strong>Oh snap!</strong>
                        Change a few things up and try submitting again.
                    </div>";
        }
    }
}
?>
