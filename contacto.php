<?php
class Contacto {
    /*variables donde se almacenaran los datos*/
    private $id;
    private $nombre;
    private $numero;

    /*el constructor recibe el nombre y el numero 
    y los asigna correspondientemente*/
    public function __construct($nombre, $numero) {
        $this->nombre = $nombre;
        $this->numero = $numero;
    }

    /*los set establecen la informacion del contacto,
    en este caso serian id y nombre y los asigna.
    con get devuelve estos valores*/
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNumero() {
        return $this->numero;
    }
}