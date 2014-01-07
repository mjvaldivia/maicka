<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */
class App_Module_Entities_Manager_Entity_Form_Login extends App_Form_Decorator_Abstract{
     /**
      * Inicia y configura el formulario
      */
     public function init() {
         parent::init();
         $this->setDecorators(array('FormElements'));
         //$this->_checkearCaptcha();
        // $this->_getElements();
     }
     
     protected function _checkearCaptcha(){
         $dir = APPLICATION_PATH . "/../public/images/captcha";
         if(is_dir($dir) AND is_writable($dir)){
             // ok
         } else {
             throw new Exception("Debe crear directorio con permisos de escritura en public/images/captcha");
         }
     }
    
    
    /**
      * Genera los campos del formulario
      */
     protected function _getElements(){
         $this->addElement("DivStart",
                          'div_login',
                            array(
                                'attribs' => array("class"=>"div-project div-form-row")
                            ))
              ->addElement("text",
                           "login_name",
                            array(
                                'label' => "Usuario",
                                'required'   => true,
                                'decorators' => $this->_textDecorator,
                                'filters'    => array('StringTrim'),
                                'validators' => array(
                                                array('NoEntityExists', false, array('entity' => 'Entities',
                                                                                     'field' => 'login',
                                                                                     'messages' => array(
                                                                                                App_Doctrine_Form_Validate_NoEntityExists::ERROR_ENTITY_EXISTS => "El nombre de usuario no esta disponible")))
                                )
                            ))
              ->addElement("password",
                           "login_password",
                            array(
                                'label' => "Contraseña",
                                'required'   => true,
                                'decorators' => $this->_textDecorator,
                                'filters'    => array('StringTrim'),
                                'validators' => array(
                                                    array('StringLength', false, array(6, 20)),
                                                 )
                            ))
               ->addElement("password",
                           "login_password_repeat",
                            array(
                                'label' => "Repita la contraseña",
                                'required'   => true,
                                'decorators' => $this->_textDecorator,
                                'filters'    => array('StringTrim'),
                                'validators' => array(
                                                    array('StringLength', false, array(6, 20)),
                                                    array('identical', false, array('token' => 'login_password',
                                                                                    'messages' => array(
                                                                                                Zend_Validate_Identical::NOT_SAME => "The password don't match")
                                                                                    )
                                                        )
                                                 )
                            ))
               /*->addElement("captcha",
                           "login_captcha",
                            array(
                                'label' => "Ingrese el siguiente código",
                                'required'   => true,
                                'filters'    => array('StringTrim'),
                                'captcha' => array(
                                    'captcha' => 'Image',
                                    'wordLen' => 6,
                                    'font'    => APPLICATION_PATH . "/../library/App/Module/Entities/Manager/Entity/Font/helvetica-cy.ttf" ,
                                    'timeout' => 300,
                                )
                            ))*/
             ->addElement("DivEnd",
                          'div_close_login');
     }
}


?>
