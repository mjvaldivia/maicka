<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

Abstract class App_Module_Entities_Manager_Associated_Email_Actions_Abstract extends App_Module_Entities_Manager_Associated{
    /**
     * Carga el formulario de telefonos
     * @return App_Module_Entities_Form_Phone_Form 
     */
    protected function _getForm(){
        $formulario = array(
                            'name'    => 'email',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'post',
                            'prefixPath' => array("path" => "App/Utilitario/Form",
                                                  "prefix" => "App_Utilitario_Form",
                                                  "type"   => \Zend_Form::ELEMENT));       
        $form = New App_Module_Entities_Manager_Associated_Email_Form_Render($formulario);
        return $form;
    }
}
?>
