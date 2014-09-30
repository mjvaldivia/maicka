<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

/**
 * Funciones para ejecutar find mas facil 
 */
class App_Doctrine_Action_Query{
    /**
     * Busca un registro por la clave primaria
     * @param /Model/Entity/+++++ $model
     * @param int $id clave primaria
     * @return /Model/Entity/+++++
     */
    static public function fetchAll($model, $query){
        $model = App_Doctrine_Repository::repository($model);
        $result = $model->{$query}();
        return $result;
    }
}
?>

