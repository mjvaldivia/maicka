<?php

Abstract class Vendor_Flex_Form_Search  extends Zend_Form {
    
    /**
     * Decorador para input text
     * @var array 
     */
    protected $_text_decorator = array(
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),

                      'Errors',
                       array('Label', array('class' => '')),
                       array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"form-group")
                             ),
                     );
    
    /**
     * Decorador para input text
     * @var array 
     */
    protected $_button_decorator = array(
                      'ViewHelper',
                      array('Description', array('class' => 'help-block')),

                      'Errors',
                       
                     );
    
    /**
     * Nombre de la grilla asociada
     * @var string
     */
    protected $_grid_name = "";
         
    /**
     * Init
     */
    public function init() {
        parent::init();
           $this->setDecorators(array('FormElements',
                                  'Form'));
        
    }
    
    /**
     * Recuerda busqueda en modulo grid2
     */
    protected function _recordarBusqueda(){
        $session = new Zend_Session_Namespace("search");
        $busqueda = $session->{$this->_grid_name};
        if(count($busqueda)>0){
            foreach($busqueda as $nombre_elemento => $valor){
                $elemento = $this->getElement($nombre_elemento);
                if(!is_null($elemento) and $valor!=""){
                    $elemento->setValue($valor);
                    $elemento->addDecorators(array(
                      array(
                             array('row'=>'HtmlTag'), 
                             array('tag'=>'div', 'class'=>"form-group has-success")
                             ),
                     ));
                    //$elemento->setAttrib("class", $elemento->getAttrib("class" . " "));
                }
            }
        }
    }
}
