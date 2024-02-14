<?php

require 'vendor/autoload.php';
require 'funciones.php';
session_start();

//$_SESSION['variable']
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

//echo $blade->run("view", array());
// MODE_DEBUG allows to pinpoint troubles.

define('PLAYER', 'archivos/PLAYER.jpg');
define('IA', 'archivos/IA.jpg');
define('FONDO', 'archivos/fondo.jpg');
define('RUTAS', array(FONDO, PLAYER, IA));

if (empty($_POST)) {
    //Se cre el tablero, se colocan las fichas y se envia al tablero para mostrar e inciar el juego.//
    $tableroYfichas = introducirFichas();
    $_SESSION['jugador'] = $tableroYfichas[1];
    $_SESSION['ia'] = $tableroYfichas[2];
    $tablero = $tableroYfichas[0];
    echo $blade->run("tablero", array('tablero' => $tablero));
} else {
    $jugador = $_SESSION['jugador'];
    $ia = $_SESSION['ia'];
    $click = array((int) $_POST['x'], (int) $_POST['y']);
    //tirada del usuario y comprobacion de casilla valida.
    $posPosiblesJ = posicionesDentroTablero(posicionesPosibles($jugador));
    $posPosiblesIA = posicionesDentroTablero(posicionesPosibles($ia));

    if (comprobarClick($click, $posPosiblesJ)) {
        //comprobamos que el click sea en la posicion de la IA y se procede a la victoria
        if ($click === $ia) {
            $result = array('clickJ' => $click,
                'posicionAnteriorIA' => $ia,
                'posicionAnteriorJ' => $jugador, 
                'rutaImg' => RUTAS, 
                'gameRes' => 0);
        } else {
            //Se comprueba si el jugador esta en el rango de la IA y genera la victoria//
            for ($i = 0; $i < count($posPosiblesIA); $i++) {
                if ($posPosiblesIA[$i] === $click) {
                    $result = array(
                        'clickIA' => $posPosiblesIA[$i],
                        'posicionAnteriorJ' => $jugador,
                        'posicionAnteriorIA' => $ia,
                        'rutaImg' => RUTAS, 
                        'gameRes' => 1);
                    break;
                }
            }
        }
        if (!isset($result)) {
            // Se manda ambos movimientos de fichas, por si no se han encontrado//
            $numAleatorio = random_int(0, (sizeof($posPosiblesIA)-1));
            $clickIA = $posPosiblesIA[$numAleatorio];
            $result = array(
                'click' => $click,
                'posicionAnteriorJ' => $jugador,
                'rutaImg' => RUTAS,
                'posicionAnteriorIA' => $ia,
                'clickIA' => $clickIA);
            $_SESSION['jugador'] = $click;
            $_SESSION['ia'] = $clickIA;
        }
    } else {
        $result = array('error' => true);
    }
    header('Content-type: application/json');
    echo json_encode($result);
}
