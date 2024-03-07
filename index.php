<?php

session_start();

require "vendor/autoload.php";
require "src/Class/usuario.php";
require 'src/Class/producto.php';

use eftec\bladeone\BladeOne;

$views = __DIR__ . '\views'; // it uses the folder /views to read the templates
$cache = __DIR__ . '\cache'; // it uses the folder /cache to compile the result. 

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

//coneccion con base de datos.
try {
    $dsn = "mysql:host=localhost;dbname=catalogo";
    $dbh = new PDO($dsn, "root", "");
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}


//inicio del programa//
//comprobamos si los campos estan vacios o no
if (empty($_POST)) {
    echo $blade->run('inicio');
    exit;
}

//variables
$iniciarSesion = filter_input(INPUT_POST, 'iniciarSesion');
$categoria = filter_input(INPUT_POST, 'categoria');
$anadirProductoId = filter_input(INPUT_POST, 'anadirProducto');
$salir = filter_input(INPUT_POST, 'salir');
$inicio = filter_input(INPUT_POST, 'irinicio');
$anadir=filter_input(INPUT_POST, 'anadir');
$modificarProduco = filter_input(INPUT_POST, 'modificarProducto');
$borrarProducto = filter_input(INPUT_POST, 'borrarProducto');



if ($iniciarSesion == "iniciarSesion") {
    //inicio de session
    $nombre = filter_input(INPUT_POST, "nombre");
    $contrasena = filter_input(INPUT_POST, "contrasena");
    $usuario = App\usuario::iniciarSesion($dbh, $nombre, $contrasena);
    if ($usuario) {
        $_SESSION["usuario"] = serialize($usuario);
        $catalogo = $usuario->Catalogo($dbh);
        echo $blade->run('categorias', ['catalogo' => $catalogo]);
        exit();
    }
} else if ($categoria) {
    //voy a pantalla de inicio
    $productos = App\producto::getProductos($dbh, $categoria);
    $_SESSION['productos']= serialize($productos);
    $usuario = unserialize($_SESSION['usuario']);
    echo $blade->run('productos', ['productos' => $productos, 'categorias' => $usuario->Catalogo($dbh), 'cat' => $categoria]);
    exit();
} else if ($anadirProductoId) {
    //voy a pantalla añadir producto
    echo $blade->run('anadirProducto',['idcategoria'=>$anadirProductoId]);
    exit();
} else if ($modificarProduco) {
    //modifico los Productos
    $idProducto = $modificarProduco;
    $nombreProducto = filter_input(INPUT_POST, 'nombre');
    $precioProducto = filter_input(INPUT_POST, 'Precio');
    $idCategoriaProducto=filter_input(INPUT_POST, 'categoriaProducto');
    $categoriaAntigua=filter_input(INPUT_POST, 'categoriaAntigua');
    
    $productos = App\producto::getProductos($dbh, $idCategoriaProducto);
    $productos= unserialize($_SESSION['productos']);
    
    $exito=$productos[$modificarProduco]->actualizar_producto($dbh,$nombreProducto,$precioProducto,$idCategoriaProducto);
    $mensaje=$exito?"Producto modificado con exito":"error modificar producto";
    $usuario = unserialize($_SESSION['usuario']);
    // con Funccion estatico
    //$mensaje=\App\producto::modificar_Producto($dbh, $idProducto, $nombreProducto, $precioProducto, $idCategoriaProducto)?"Producto modificado con exito ":"Error modificar el producto";
    echo $blade->run('productos', ['mensaje'=>$mensaje, 'productos' => $productos, 'categorias' => $usuario->Catalogo($dbh), 'cat' => $categoriaAntigua]);
    exit();
    
} else if ($borrarProducto) {
    
    $idProducto = $borrarProducto;
    $nombreProducto = filter_input(INPUT_POST, 'nombre');
    $precioProducto = filter_input(INPUT_POST, 'precio');
    $idCategoriaProducto=filter_input(INPUT_POST, 'categoriaProducto');
    $producto=new \App\producto($idProducto, $nombreProducto, $precioProducto, $idCategoriaProducto);
    
    $mensaje=$producto->borrarProducto($dbh, $idProducto)?"Producrto borrado con exito":"Error borrando producto";
    
    $productos = App\producto::getProductos($dbh, $idCategoriaProducto);
   
    $usuario = unserialize($_SESSION['usuario']);
    echo $blade->run('productos', ['productos' => $productos, 'categorias' => $usuario->Catalogo($dbh), 'cat' => $idCategoriaProducto, 'mensaje'=>$mensaje]);
    exit();
    
} else if ($inicio == 'irinicio') {
    $usuario = unserialize($_SESSION['usuario']);
    echo $blade->run('categorias', ['catalogo' => $usuario->Catalogo($dbh)]);
    exit();
} else if ($salir == "salir") {
    session_destroy();
    echo $blade->run('inicio');
    exit();
}else if($anadir){
    $nombreProducto = filter_input(INPUT_POST, 'nombre');
    $precioProducto = filter_input(INPUT_POST, 'Precio');
    $idCategoriaProducto=filter_input(INPUT_POST, 'idcategoria');
    $nuevoProducto=App\producto::crearProducto($dbh, $nombreProducto, $precioProducto, $idCategoriaProducto);
    $productos = App\producto::getProductos($dbh, $idCategoriaProducto);
    
    $usuario = unserialize($_SESSION['usuario']);
    $productos[$anadir]=$nuevoProducto;
    
    $_SESSION['productos']= serialize($productos);
    $mensaje=$nuevoProducto?"Producto creado con exito ":"Error crear el roducto";
    echo $blade->run('productos', ['mensaje'=>$mensaje,'productos' => $productos, 'categorias' => $usuario->Catalogo($dbh), 'cat' => $idCategoriaProducto]);
    exit();
}
?>