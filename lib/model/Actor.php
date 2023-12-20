<?php

class Actor {

    private $id;
    private $nombre;
    private $apellidos;
    private $fotografía;

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

    public function __toString() {
        return $this->getNombre() . " " . $this->getApellidos();
    }
}
