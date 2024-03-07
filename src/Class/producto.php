<?php

namespace App;

use PDO;

class producto {

    private $id;
    private $nombre;
    private $precio;
    private $categoria;

    public function __construct($id, $nombre, $precio, $categoria) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public static function getProductos($dbh, $categoria) {

        $stmt = $dbh->query("SELECT id,nombre,precio,id_categoria FROM productos where id_categoria=$categoria");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productos as $producto) {
            $arrProductos[$producto['id']] = new producto($producto['id'], $producto['nombre'], $producto['precio'], $producto['id_categoria']);
        }

        return $arrProductos;
    }

    public function borrarProducto($dbh, $id) {
        //borra el usuario en base de datos
        $borrar = $dbh->prepare("DELETE FROM productos WHERE id='$id'");
        $borrar->execute();
        return $borrar;
    }
    //OBSOLETO
    public static function modificar_Producto($dbh, $id, $nombre, $precio, $idCategoria) {
        //modifico los datos de producto en base de datos
        $bdpreparado = $dbh->prepare("UPDATE productos SET nombre='$nombre',precio='$precio', id_categoria='$idCategoria' WHERE id='$id'");
        $bdpreparado->execute();
        return $bdpreparado;
    }
    
    
    public function actualizar_producto($dbh, $nombre, $precio, $idCategoria) {
        $sql = "UPDATE productos SET nombre='$nombre',precio='$precio', id_categoria='$idCategoria' WHERE id='$this->id'";
        $bdpreparado = $dbh->prepare($sql);
        
        $this->nombre=$nombre;
        $this->precio=$precio;
        $this->categoria=$idCategoria;
        $bdpreparado->execute();    
        return $bdpreparado;
    }

        public static function crearProducto($dbh, $nombre, $precio, $idCategoria) {

        //comprobamos el nombre
        $comprobarNombre = $dbh->prepare("select nombre from productos where nombre='$nombre'");
        $comprobarNombre->setFetchMode(PDO::FETCH_ASSOC);
        $comprobarNombre->execute();
        $n = $comprobarNombre->fetch();

        if ($n != false) {
            return false;
        }

        //asignamos el id
        $maxid = $dbh->prepare("select max(id) from productos");
        $maxid->setFetchMode(PDO::FETCH_ASSOC);
        $maxid->execute();
        $row = $maxid->fetch();
        $id = $row["max(id)"];
        $id += 1;

        //inseertamos el usuario
        $stmt = $dbh->prepare("INSERT INTO productos(id, nombre, precio, id_categoria) VALUES ('$id','$nombre','$precio','$idCategoria')");
        $stmt->execute();
        $producto=new producto($id, $nombre, $precio, $idCategoria);
        return $producto;
    }

}

?>