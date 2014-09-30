<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Class App_Formato_fecha{
    
    /**
     * Da formato a una fecha
     * @param string $formato
     * @param \DateTime $fecha
     */
    static public function formato($formato, $fecha){
        if($fecha instanceof DateTime){
           return $fecha->format($formato);
        } else {
           return "";
        }
    }
}

?>
