<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

abstract class Vendor_Google_Abstract{
    
    protected $_config;
    
    public function __construct() {
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/../library/App/Module/Google/Config/google.ini', APPLICATION_ENV);
    }
}
?>
