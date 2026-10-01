<?php

// Activamos el tipado estricto del archivo.
declare(strict_types=1);

// Creamos un catálogo de vehículos de la flota.
// Incluimos tildes y caracteres especiales para trabajar posteriormente
// con funciones de tratamiento de texto multibyte.
$flota = [
    [
        "modelo" => "Renault Mégane E-Tech",
        "categoria" => "vehículo eléctrico",
        "autonomia" => 450
    ],
    [
        "modelo" => "Peugeot ë-208",
        "categoria" => "turismo eléctrico",
        "autonomia" => 362
    ],
    [
        "modelo" => "Citroën ë-C4",
        "categoria" => "turismo eléctrico",
        "autonomia" => 420
    ],
    [
        "modelo" => "Volkswagen ID.4",
        "categoria" => "vehículo eléctrico",
        "autonomia" => 520,
        "descuento" => null
    ]
];

// Recorremos todos los vehículos del catálogo.
foreach ($flota as &$vehiculo) {

    // Convertimos la categoría a formato título.
    $vehiculo["categoria"] = mb_convert_case(
        $vehiculo["categoria"],
        MB_CASE_TITLE,
        "UTF-8"
    );

    // Convertimos el nombre del modelo a mayúsculas.
    $vehiculo["modelo"] = mb_strtoupper(
        $vehiculo["modelo"],
        "UTF-8"
    );

    // Calculamos la longitud exacta del modelo en caracteres.
    $vehiculo["longitud"] = mb_strlen(
        $vehiculo["modelo"],
        "UTF-8"
    );
}

unset($vehiculo);

// Comprobamos si la clave "descuento" existe en el vehículo.
$tieneClave = array_key_exists("descuento", $flota[3]);

// Comprobamos si "descuento" tiene un valor distinto de null.
$tieneValor = isset($flota[3]["descuento"]);

// Ordenamos la flota de mayor a menor según la autonomía.
// El operador <=> realiza una comparación de tres vías.
usort($flota, function (array $a, array $b): int {
    return $b["autonomia"] <=> $a["autonomia"];
});