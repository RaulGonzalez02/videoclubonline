<?php
/**
 * Clase Pelicula
 */
class Pelicula {

    /**
     * Propiedad id
     * Id de la pelicula
     * @var integer
     */
    private $id;
    
    /**
     * Propiedad titulo
     * Titulo de la pelicula
     * @var string
     */
    private $titulo;
    
    /**
     * Propiedad genero
     * Genero de la pelicula
     * @var string
     */
    private $genero;
    
    /**
     * Propiedad pais
     * Pais de la pelicula
     * @var string
     */
    private $pais;
    
    /**
     * Propiedad anyo
     * Anyo de la pelicula
     * @var integer
     */
    private $anyo;
    
    /**
     * Propiedad cartel
     * Cartel de la pelicula
     * @var string
     */
    private $cartel;

    /**
     * Constructor de la clase usuario
     * @param integer $id
     * @param string $titulo
     * @param string $genero
     * @param string $pais
     * @param integer $anyo
     * @param string $cartel
     */
    function __construct($id, $titulo, $genero, $pais, $anyo, $cartel) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->pais = $pais;
        $this->anyo = $anyo;
        $this->cartel = $cartel;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getAnyo() {
        return $this->anyo;
    }

    public function getCartel() {
        return $this->cartel;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    public function setGenero($genero): void {
        $this->genero = $genero;
    }

    public function setPais($pais): void {
        $this->pais = $pais;
    }

    public function setAnyo($anyo): void {
        $this->anyo = $anyo;
    }

    public function setCartel($cartel): void {
        $this->cartel = $cartel;
    }

    /**
     * __toString de la clase pelicula
     * @return string
     */
    function __toString() {
        return "La pelicula es: "
                . $this->getTitulo() . ", del genero " . $this->getGenero()
                . " fue estrenada en el año " . $this->getAnyo() . " y creada en "
                . $this->getPais() . ".";
    }
}
