<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clientes
 *
 * @Table(name="template")
 * @Entity(repositoryClass="Model\Entity\Repository\TemplateRepository")
 */
class Template
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string $name
     *
     * @Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;
    
    /**
     * @var string $name
     *
     * @Column(name="ubicacion", type="string", length=45, nullable=true)
     */
    private $ubicacion;
    
    /**
     * Devuelve la clave primaria
     * @return int 
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Devuelve el nombre
     * @return string 
     */
    public function getNombre(){
        return $this->nombre;
    }
    
    /**
     * Setea el nombre
     * @param string $name 
     */
    public function setNombre($name){
        $this->nombre = $name;
    }
    
    /**
     * Retorna la ubicacion
     */
    public function getUbicacion(){
        return $this->ubicacion;
    }
    
    /**
     * 
     * @param string $ubicacion
     */
    public function setUbicacion($ubicacion){
        $this->ubicacion = $ubicacion;
    }
}

