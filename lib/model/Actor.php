<?php

/**
 * Clase Actor
 */
class Actor {

    /**
     * Propiedad id
     * Id del actor
     * @var integer
     */
    private $id;
    
    /**
     * Propiedad nombre
     * Nombre del actor
     * @var string
     */
    private $nombre;
    
    /**
     * Propiedad apellidos
     * Apellidos del actor
     * @var string
     */
    private $apellidos;
    
    /**
     * Propiedad fotografia
     * Fotografia del actor
     * @var string
     */
    private $fotografía;

    /**
     * Constructor de la clase actor
     * @param integer $id
     * @param string $nombre
     * @param string $apellidos
     * @param string $fotografia
     */
    public function __construct($id, $nombre, $apellidos, $fotografia) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fotografía = $fotografia;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getFotografía() {
        return $this->fotografía;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos): void {
        $this->apellidos = $apellidos;
    }

    public function setFotografía($fotografía): void {
        $this->fotografía = $fotografía;
    }

    /**
     * __toString de la clase actor
     * @return string
     */
    public function __toString() {
        return $this->getNombre() . " " . $this->getApellidos();
    }
}
