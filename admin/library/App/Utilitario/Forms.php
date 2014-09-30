<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2013 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 *
 */

/**
 * Decoradores para campos de formulario
 */
Class App_Utilitario_Forms extends Zend_Form{
    
    /**
     * Decorador para texto
     * @var array
     */
    protected $_textDecorator = array(
                      array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'controls', 'openOnly' => true, 'placement' => 'append')),
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),
                      array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                      'Errors',
                       array('Label', array('class' => 'control-label')),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"control-group")
                             ),
                        
                     );
    /**
     * Decorador para texto
     * @var array
     */
    protected $_text_big_decorator = array(
                      array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'controls controls-big', 'openOnly' => true, 'placement' => 'append')),
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),
                      array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                      'Errors',
                       array('Label', array('class' => 'control-label')),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"control-group")
                             ),
                        
                     );
    
    protected $_text_min_Decorator = array(
                      array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'controls controls-min', 'openOnly' => true, 'placement' => 'append')),
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),
                      array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                      'Errors',
                       array('Label', array('class' => 'control-label control-label-min')),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"control-group control-group-min")
                             ),
                        
                     );
    
    protected $_textErrorDecorator = array(
                      array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'controls', 'openOnly' => true, 'placement' => 'append')),
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),
                      array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                      array('Errors', array("class" => "error-input-message") ),
                      array('Label',  array('class' => 'control-label')),
                      array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"control-group error")
                             ),
                        
                     );
    
    protected $_textHiddenDecorator = array(
                      array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'controls', 'openOnly' => true, 'placement' => 'append')),
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),
                      array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                      array('Errors', array("class" => "help-inline") ),
                      array('Label',  array('class' => 'control-label')),
                      array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"control-group hidden")
                             ),
                        
                     );
    
    /**
     * Decorador para un elemento oculto
     * @var array 
     */
    protected $_hiddenDecorator = array('ViewHelper',
                                        array('Label'),
                                        array());
    
    /**
     * Decorador para texto
     * @var array
     */
    protected $_buttonDecorator = array(
                    //  array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'controls', 'openOnly' => true, 'placement' => 'append')),
                      'ViewHelper',
                     // array('Description', array('class' => 'help-block')),
                     // array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                      //'Errors',
                      // array('Label', array('class' => 'control-label')),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"form-actions")
                             ),
                        
                     );
    
    /**
     * Init
     */
    public function init() {
        parent::init();
        $this->addElementPrefixPath('App_Doctrine_Form_Validate',
                                    'App/Doctrine/Form/Validate',
                                    'validate');
        $this->setDecorators(array(
                                'FormElements',
                                 array('HtmlTag', 
                                        array('tag'=>'fieldset')
                                      ),
                                 'Form'
                                  )
                            );
        
        $this->setAttrib('class', 'form-horizontal');
        $this->setElementDecorators(array(array()));
    }
    
    /**
     * 
     * @return array
     */
    static public function hiddenDecorator(){
       $form = New App_Utilitario_Forms();
       return $form->getHiddenDecorator();
    }
    
    /**
     * 
     * @return array
     */
    static public function textDecorator(){
       $form = New App_Utilitario_Forms();
       return $form->getTextDecorator(); 
    }
    
    /**
     * 
     * @return array
     */
    static public function textMinDecorator(){
       $form = New App_Utilitario_Forms();
       return $form->getTextMinDecorator(); 
    }
    
    /**
     * 
     * @return array
     */
    static public function textErrorDecorator(){
       $form = New App_Utilitario_Forms();
       return $form->getErrorDecorator(); 
    }
    
    /**
     * 
     * @return type
     */
    public function getErrorDecorator(){
        return $this->_textErrorDecorator;
    }
    
    /**
     * 
     * @return array
     */
    public function getHiddenDecorator(){
        return $this->_textHiddenDecorator;
    }
    
    /**
     * 
     * @return array
     */
    public function getTextDecorator(){
        return $this->_textDecorator;
    }
    
    /**
     * 
     * @return array
     */
    public function getTextMinDecorator(){
        return $this->_text_min_Decorator;
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
              $this->{$input}->setDecorators($this->_textErrorDecorator);
           }
       }
    }
}
?>
