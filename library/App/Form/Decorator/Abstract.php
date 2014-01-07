<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

/**
 * Configuracion basica para los formularios
 */
Abstract class App_Form_Decorator_Abstract  extends Zend_Form {
    
    /**
     * Decorador para campos de texto
     * @var array 
     */
    protected $_textDecorator;
    
    /**
     * Decorador para botones
     * @var array
     */
    protected $_buttonDecorator = array('ViewHelper');
    
    protected $_checkboxDecorator;
    
    protected $_radioDecorator = array('ViewHelper',
                                       'Errors',
                                       'Description',
                                       array('Label'),  
                                       array(array('row'   => 'HtmlTag'), 
                                             array('tag'   => 'div', 
                                                   'class' => 'radio')));
   
    /**
     * Decorador para un elemento oculto
     * @var array 
     */
    protected $_hiddenDecorator = array('ViewHelper',
                                        array('Label'),
                                        array());
    
    /**
     * Prepara el formulario
     */
    public function init(){
        $this->addElementPrefixPath('App_Doctrine_Form_Validate',
                                    'App/Doctrine/Form/Validate',
                                    'validate');
        
       $this->_textDecorator = $this->dinamicTextDecoratorClass();
       $this->_checkboxDecorator = $this->dinamicCheckboxDecoratorClass();
       $this->setDecorators(array('FormElements',
                                  array('HtmlTag', 
                                        array('tag'=>'div')),
                                  'Form'));

       $this->setElementDecorators(array(array()));
    }
    
    /**
     * Carga el decorador de text, pero permite añadir 
     * otra clase de css
     * @param type $class
     * @return type 
     */
    public function dinamicTextDecoratorClass($addClass = NULL){
        
        if(!is_null($addClass)) $class = 'element '.$addClass;
        else $class = 'element';
        
       $array = array(
                      'ViewHelper',
                      'Errors',
                      'Description',
                       array('Label'),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>$class)
                             )
                     ); 
        
        
       return $array;
    }
    
    /**
     * Carga el decorador de checkbox, pero permite añadir 
     * otra clase de css
     * @param type $class
     * @return type 
     */
    public function dinamicCheckboxDecoratorClass($addClass = NULL){
        
        if(!is_null($addClass)) $class = 'element checkbox '.$addClass;
        else $class = 'element checkbox';
        
        $array = array(
                        'ViewHelper',
                        'Errors',
                        'Description',
                         array('Label'),
                         array(
                                array('row'=>'HtmlTag'), 
                                array('tag'=>'div', 'class'=>$class)),

                         );
        return $array;
    }
    
    /**
     * Agrega la clase error a los campos que tengan errores
     */
    public function processErrors(){
       $errors = $this->getErrors();
       foreach($errors as $input => $error){
           $sw = false;
           foreach($error as $msg){
               $sw = true;
           }
           if($sw){              
              $this->{$input}->setDecorators(App_Utilitario_Forms::textErrorDecorator());
           }
       }
    }
    


}
?>
