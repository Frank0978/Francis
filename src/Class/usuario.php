<?php

namespace App;

use PDO;

class usuario {

    private $id;
    private $nombre;
    private $contrasena;

    public function __construct($id, $nombre, $contrasena) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->contrasena = $contrasena;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public static function iniciarSesion($dbh, $nombre, $contrasena) {
        $stmt = $dbh->prepare("SELECT * FROM usuarios where nombre='$nombre' and password='$contrasena'");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row == null) {
            return false;
        } else if ($row['nombre'] == $nombre && $row['password'] == $contrasena) {
            return new usuario($row['id'], $nombre, $contrasena);
        }
    }
    
   
    
    public function Catalogo($dbh) {
        $stmt = $dbh->query("SELECT nombre,id FROM categorias");
        $catalogo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $catalogo;
    }
}
?>