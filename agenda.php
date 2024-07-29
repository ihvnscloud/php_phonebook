<?php
class Agenda {
    /*array para almacenar los contactos de la agenda*/
    private $contactos = array();

    /*el constructor inicializa el array*/
    public function __construct() {
        $this->contactos = array();
    }

    /*registra un nuevo contacto, recibe el nombre y el
    numero y los guarda en la base de datos y muestra un
    mensaje depediendo del resultado de la consulta*/
    public function registrarContacto($nombre, $numero) {
        global $conn;

        $sql = "INSERT INTO contactos (nombre, numero) VALUES ('$nombre', '$numero')";
        if ($conn->query($sql) === TRUE) {
            return "Contacto registrado exitosamente.";
        } else {
            return "Error al registrar el contacto: " . $conn->error;
        }
    }

    /*muestra todos los contactos guardados en la base de
    datos, se crea una instancia de contacto y se agregan 
    al array de contactos, luego la devuelve o muestra el mensaje*/
    public function listarContactos() {
        global $conn;
        $sql = "SELECT * FROM contactos";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $contactos = array();
            while($row = $result->fetch_assoc()) {
                $contacto = new Contacto($row["nombre"], $row["numero"]);
                $contacto->setId($row["id"]);
                $contactos[] = $contacto;
            }
            return $contactos;
        } else {
            return "No hay contactos registrados.";
        }
    }

    /*busca un contacto en la base de datos por su nombre,
    se crea una instancia de contacto con los datos obtenidos
    y la devuelve o si no muestra un mensaje*/
    public function buscarContacto($nombre) {
        global $conn;
        $sql = "SELECT * FROM contactos WHERE nombre = '$nombre'";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contacto = new Contacto($row["nombre"], $row["numero"]);
            $contacto->setId($row["id"]);
            return $contacto;
        } else {
            return "No se encontró el contacto.";
        }
    }

    /*elimina un contacto de la base de datos y muestra
    su correspondiente mensaje*/
    public function eliminarContacto($id) {
        global $conn;

        $sql = "DELETE FROM contactos WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            return "Contacto eliminado exitosamente.";
        } else {
            return "Error al eliminar el contacto: " . $conn->error;
        }
    }
}