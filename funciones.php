<?php

function crearTablero() {
    return $tablero = array_fill(0, 8, array_fill(0, 8, FONDO));
}

function introducirFichas() {
    $tablero = crearTablero();
    $jugador = array(random_int(0, 7), random_int(0, 7));
    $ia = array(random_int(0, 7), random_int(0, 7));
    do {
        while (!comprobarEsquinas($jugador)) {
            $jugador = array(random_int(0, 7), random_int(0, 7));
        }
        $alrededorJugador = fichasAlrededor($jugador);
        while (!comprobarEsquinas($ia) || !comprobarAlrededores($ia, $alrededorJugador)) {
            $ia = array(random_int(0, 7), random_int(0, 7));
        }
    } while ($jugador === $ia);
    $tablero[$jugador[0]][$jugador[1]] = PLAYER;
    $tablero[$ia[0]][$ia[1]] = IA;
    return array($tablero, $jugador, $ia);
}

function fichasAlrededor($ficha): array {
    $fichasAlrededor = []; 
    for ($f = -1; $f < 2; $f++) {
        for ($c = -1; $c < 2; $c++) {
            array_push($fichasAlrededor, array($ficha[0] + $f, $ficha[1] + $c));
        }
    }
    return $fichasAlrededor;
}

function comprobarEsquinas($ficha) {
    $posicionesNoValidas = [array(0, 0), array(7, 7), array(0, 7), array(7, 0)];
    for ($j = 0; $j < count($posicionesNoValidas); $j++) {
        if ($ficha === $posicionesNoValidas[$j]) {
            return false;
        }
    }
    return true;
}

function comprobarAlrededores($ia, $fichas) {
    for ($z = 0; $z < count($fichas); $z++) {
        if ($ia === $fichas[$z]) {
            return false;
        }
    }
    return true;
}

function posicionesPosibles($ficha): array {
    $posicionesPosibles = array(
        array($ficha[0] + -2, $ficha[1] + -1), array($ficha[0] + -2, $ficha[1] + 1),
        array($ficha[0] + -1, $ficha[1] + -2), array($ficha[0] + -1, $ficha[1] + 2),
        array($ficha[0] + 1, $ficha[1] + -2), array($ficha[0] + 1, $ficha[1] + 2),
        array($ficha[0] + 2, $ficha[1] + -1), array($ficha[0] + 2, $ficha[1] + 1));
    return $posicionesPosibles;
}

function comprobarClick(array $click, array $posicionesPosibles): bool {
    foreach ($posicionesPosibles as $posicion) {
        if ($posicion === $click) {
            return true;
        }
    }
    return false;
}
function posicionesDentroTablero(array $pos): array {
    $posicionesAmoverse = [];
    //comprueba si la posicion del array esta dentro de los limites del tablero
    for ($i = 0; $i < count($pos); $i++) {
        if (isset($pos[$i][0]) && isset($pos[$i][1])) {
            if ($pos[$i][0] >= 0 && $pos[$i][0] < 8 && $pos[$i][1] >= 0 && $pos[$i][1] < 8) {
                if (isset($posicionesAmoverse)) {
                    array_push($posicionesAmoverse, $pos[$i]);
                } else {
                    $posicionesAmoverse = array($pos[$i]);
                }
            }
        }
    }
    return $posicionesAmoverse;
}