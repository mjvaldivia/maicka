<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clientes
 *
 * @Table(name="clientes")
 * @Entity(repositoryClass="Model\Entity\Repository\ClientesRepository")
 */
class Clientes{
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
     * @Column(name="url_produccion", type="string", length=80, nullable=true)
     */
    private $url_produccion;
    
    /**
     * @var string $name
     *
     * @Column(name="url_development", type="string", length=80, nullable=true)
     */
    private $url_development;
    
        /**
     * @var Country
     *
     * @ManyToOne(targetEntity="Template")
     * @JoinColumns({
     *   @JoinColumn(name="id_template", referencedColumnName="id")
     * })
     */
    private $template;


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
     * Url produccion
     * @return string
     */
    public function getUrlProduccion(){
        return $this->url_produccion;
    }
    
    /**
     * 
     * @param string $url
     */
    public function setUrlProduccion($url){
        $this->url_produccion = $url;
    }
    
    /**
     * 
     * @return string
     */
    public function getUrlDevelopment(){
        return $this->url_development;
    }
    
    /**
     * String
     * @param int $url
     */
    public function setUrlDevelopment($url){
        $this->url_development = $url;
    }
    
    /**
     * 
     * @return \Model\Entity\Template
     */
    public function getTemplate(){
        return $this->template;
    }
    
    /**
     * 
     * @param \Model\Entity\Template $template
     */
    public function setTemplate($template){
        $this->template = $template;
    }
}

