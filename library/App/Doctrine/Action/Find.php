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
class App_Doctrine_Action_Find{
    /**
     * Busca un registro por la clave primaria
     * @param /Model/Entity/+++++ $model
     * @param int $id clave primaria
     * @return /Model/Entity/+++++
     */
    static public function primary($model, $id){
        if($id != ""){
            $model = App_Doctrine_Repository::repository($model);
            $result = $model->find($id);
            return $result;
        } else return null;
    }
}
?>
