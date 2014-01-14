<?php

namespace Model\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class ModelEntityClientesProxy extends \Model\Entity\Clientes implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }
    
    
    public function getId()
    {
        $this->__load();
        return parent::getId();
    }

    public function getNombre()
    {
        $this->__load();
        return parent::getNombre();
    }

    public function setNombre($name)
    {
        $this->__load();
        return parent::setNombre($name);
    }

    public function getUrlProduccion()
    {
        $this->__load();
        return parent::getUrlProduccion();
    }

    public function setUrlProduccion($url)
    {
        $this->__load();
        return parent::setUrlProduccion($url);
    }

    public function getUrlDevelopment()
    {
        $this->__load();
        return parent::getUrlDevelopment();
    }

    public function setUrlDevelopment($url)
    {
        $this->__load();
        return parent::setUrlDevelopment($url);
    }

    public function getTemplate()
    {
        $this->__load();
        return parent::getTemplate();
    }

    public function setTemplate($template)
    {
        $this->__load();
        return parent::setTemplate($template);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'nombre', 'url_produccion', 'url_development', 'template');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}