<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Cache_Set{
    
    public static function  cacheEterno(){
        $frontendOptions = array(
           'lifetime' => 136000,
           'automatic_serialization' => true  
        );
        $backendOptions = array('cache_dir' => APPLICATION_PATH . '/../temp/');
        $cache          = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
        return $cache;
    }
}

?>
