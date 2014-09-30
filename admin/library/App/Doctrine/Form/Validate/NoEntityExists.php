<?php

/**
 * Shorthill
 *
 * @copyright   Copyright (c) 2011 Shorthill Solutions (http://www.shorthillsolutions.com)
 * @author      Carlos Ayala <carlos.ayala@shorthillsolutions.com>
 */

/**
 * Ve si un registro no exista ya en una tabla
 */
class App_Doctrine_Form_Validate_NoEntityExists extends Zend_Validate_Abstract{

  private $_ec = null;
  private $_property = null;
  private $_exclude = null;

  const ERROR_ENTITY_EXISTS = 1;
  
  /**
   * Mensajes de error
   * @var type 
   */
  protected $_messageTemplates = array(
    self::ERROR_ENTITY_EXISTS => 'Another record already contains %value%'  
  );

  /**
   * Inicia el validador
   * @param array $opts array('entity' => 'Entity Class','field' => 'login')
   */
  public function __construct($opts){
    $this->_ec = $opts['entity'];
    $this->_property = $opts['field'];
    if(isset($opts['exclude'])) $this->_exclude = $opts['exclude'];
    $this->_em = App_Doctrine_Repository::entityManager();
  }
  

  
  /**
   * Devuelve el entity manager
   * @return type 
   */
  public function em(){
    return $this->_em;
  }

  /**
   * Arma la query
   * @return type 
   */
  public function getQuery(){
    $qb = $this->em()->createQueryBuilder();
    $qb->select('o')
            ->from("\\Model\\Entity\\" .$this->_ec,'o')
            ->where('o.' . $this->_property .'=:value');

    if ($this->_exclude !== null){ 
      if (is_array($this->_exclude)){

        foreach($this->_exclude as $k=>$ex){                    
          $qb->andWhere('o.' . $ex['property'] .' != :value'.$k);
          $qb->setParameter('value'.$k,$ex['value'] ? $ex['value'] : '');
        }
      } 
    }
    $query = $qb->getQuery();
    
    
    //fb(__METHOD__ . " - " . $query->getDql() . " Valor:" .$ex['value']);
    
    return $query;
  }
  
  /**
   * Valida que el campo no exista
   * @param type $value
   * @return boolean 
   */
  public function isValid($value){
    $valid = true;

    $this->_setValue($value);

    $query = $this->getQuery();
    $query->setParameter("value", $value);

    $result = $query->execute();

    if (count($result)){ 
      $valid = false;
      $this->_error(self::ERROR_ENTITY_EXISTS);
    }
    return $valid;

  }
}
?>
