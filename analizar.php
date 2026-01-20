<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// LEE Y'
function normalizarNotacion($ecuacion) {
    return preg_replace_callback(
        "/y('+)/",
        function($matches) {
            $n = strlen($matches[1]);
            return "d{$n}y/dx{$n}";
        },
        $ecuacion
    );
}

function obtenerOrden($ecuacion) {
    $ecuacion = strtolower($ecuacion);
    $ecuacion = str_replace(" ", "", $ecuacion);

    // NUEVO: normalizar y'
    $ecuacion = normalizarNotacion($ecuacion);

// RESUELVE DY/DX 
    preg_match_all('/d(\d*)y\/dx(\d*)/', $ecuacion, $matches);

    if (empty($matches[0])) {
        return "No es una ecuación diferencial";
    }

    $orden = 0;

    foreach ($matches[1] as $n) {
        $n = ($n === "") ? 1 : intval($n);
        if ($n > $orden) {
            $orden = $n;
        }
    }

    return $orden;
}

function obtenerGrado($ecuacion) {
    $ecuacion = strtolower($ecuacion);
    $ecuacion = str_replace(" ", "", $ecuacion);
    $ecuacion = normalizarNotacion($ecuacion);

    $ordenMax = obtenerOrden($ecuacion);

    if ($ordenMax == 1) {
        // acepta (dy/dx)^k y (d1y/dx1)^k
        $patron = "/\\(d?1?y\\/dx1?\\)\\^(\\d+)/";
    } else {
        $patron = "/\\(d{$ordenMax}y\\/dx{$ordenMax}\\)\\^(\\d+)/";
    }

    if (preg_match($patron, $ecuacion, $match)) {
        return intval($match[1]);
    }

    return 1;
}


function esLineal($ecuacion) {
    $ecuacion = strtolower($ecuacion);
    $ecuacion = str_replace(" ", "", $ecuacion);
    $ecuacion = normalizarNotacion($ecuacion);

    // y^n (n>1)
    if (preg_match('/y\^\d+/', $ecuacion)) {
        return false;
    }

    // (derivada)^n
    if (preg_match('/\(d\d*y\/dx\d*\)\^\d+/', $ecuacion)) {
        return false;
    }

    // y * derivada
    if (preg_match('/y\*d\d*y\/dx\d*/', $ecuacion) ||
        preg_match('/d\d*y\/dx\d*\*y/', $ecuacion)) {
        return false;
    }

    // funciones no lineales comunes
    if (preg_match('/sin\(y\)|cos\(y\)|exp\(y\)/', $ecuacion)) {
        return false;
    }

    return true;
}

function obtenerTipo($ecuacion) {
    $ecuacion = strtolower($ecuacion);

    if (strpos($ecuacion, '∂') !== false) {
        return "Parcial";
    }

    return "Ordinaria";
}

?>
