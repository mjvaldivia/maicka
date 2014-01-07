<?php
abstract class App_SPL_Abstract {
    protected $fieldTypes = array();

    protected $_id;

    public function __construct($id = ""){
        $this->_id = $id;
       
    }

    /**
     * fetch all the items
     * @return array
     */
    public function getFieldTypes(){
        return $this->fieldTypes;
    }

    /**
     * Get the name for actual item
     * @return type 
     */
    public function getName(){
        if($this->_error()) return $this->fieldTypes[$this->_id];
        else return NULL;
    }

    /**
     * Get the ID for actual item
     * @return type 
     */
    public function getId(){
        if($this->_error()) return $this->_id;
        else return NULL;
    }

    public function getFieldTypesNotIn($data = false){
        $types = $this->fieldTypes;
       
        foreach ($data as $selected) {
             unset ($types[$selected["id"]]);
        }

        return $types;
    }
    
    protected function _error(){
         if(isset($this->fieldTypes[$this->_id])){
            return true;
         } else return false;
    }
}

?>
