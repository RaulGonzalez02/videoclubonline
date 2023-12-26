<?php
/**
 * CLASE USUARIO
 */
class Usuario{
    /**
     * Propiedad id
     * Id de usuario
     * @var integer
     */
    private $id;
    
    /**
     * Propiedad username
     * Nombre de usuario
     * @var string
     */
    private $username;
    
    /**
     * Propiedad password
     * Password del usuario
     * @var string
     */
    private $password;
    
    /**
     * Propiedad rol
     * Rol del usuario
     * @var integer
     */
    private $rol;
    
    /**
     * Constructor de la clase Usuario
     * @param integer $id
     * @param string $username
     * @param string $password
     * @param integer $rol
     */
    function __construct($id, $username, $password, $rol) {
        $this->id=$id;
        $this->username=$username;
        $this->password=$password;
        $this->rol=$rol;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setRol($rol): void {
        $this->rol = $rol;
    }
    
    /**
     * __toString de la clase usuario
     * @return string
     */
    function __toString() {
        return $this->getUsername()." con el rol ".$this->getRol();
    }
}

