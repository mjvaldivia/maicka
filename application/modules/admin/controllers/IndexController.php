<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

class Admin_IndexController extends Zend_Controller_Action{
    
    public function init() {
      
    }
    
    public function indexAction(){
        $this->_redirect("/admin/ordenes");
    }
}
?>
