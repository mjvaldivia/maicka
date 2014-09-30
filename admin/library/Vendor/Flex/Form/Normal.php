<?php

Abstract class Vendor_Flex_Form_Normal  extends Zend_Form {
    
    /**
     * Init
     */
    public function init() {
        parent::init();
           $this->setDecorators(array('FormElements',
                                  'Form'));
    }
    
    /**
     * Decorador para texto
     * @return array
     */
    public function getRadioDecorator(){
        return array(
                    'ViewHelper',
                    'Errors',
                    'Description',
                     array('Label', array('class' => 'col-sm-2 control-label')),
                     array(
                            array('row'=>'HtmlTag'), 
                            array('tag'=>'div', 'class'=>'form-group clearfix')),
                     );
    }
    
    /**
     * Decorador para texto
     * @return array
     */
    public function getHiddenDecorator(){
        return array(
            'ViewHelper',
            array('Label'),
            array()
        );
    }
    
    /**
     * Decorador para texto
     * @return array
     */
    public function getTextDecorator(){
        return array(
                      array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'col-sm-10', 'openOnly' => true, 'placement' => 'append')),
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),
                      array(new Vendor_Flex_Form_Decorador_Error(),array('class' => 'help-block','escape' => true)),
                      array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                       array('Label', array('class' => 'col-sm-2 control-label')),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"form-group clearfix")
                             ),
                     );
    }
    
    /**
     * Decorador para moneda
     * @return array
     */
    public function getMoneyDecorator(){
        return array(
                      array(array('StartInputWrapper' => 'HtmlTag'), array('tag'=>'div', 'class'=>'col-sm-10', 'openOnly' => true, 'placement' => 'append')),
                      array(array('StartInputGroup' => 'HtmlTag'), array('tag'=>'div', 'class'=>'input-group', 'openOnly' => true, 'placement' => 'append')),
                      array(new Vendor_Flex_Form_Decorador_Money(),array('class' => 'help-block','escape' => true)),
                      'ViewHelper',
                      array(array('EndInputGroup' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                      array('Description', array('class' => 'help-block')),
                      array(new Vendor_Flex_Form_Decorador_Error(),array('class' => 'help-block','escape' => true)),
                      array(array('EndInputWrapper' =>'HtmlTag'), array('tag'=>'div', 'closeOnly' => true, 'placement'=>'append')),
                       array('Label', array('class' => 'col-sm-2 control-label')),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"form-group clearfix")
                             ),
                     );
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
              $this->{$input}->addDecorators(array(
                      array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"form-group has-error clearfix")
                             ),
                     ));
           }
       }
    }
}

