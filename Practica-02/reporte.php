<?php

// Activamos el tipado estricto del archivo.
declare(strict_types=1);

// Iniciamos un búfer de salida para almacenar temporalmente el reporte.
ob_start();

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

// Mostramos la diferencia entre ambas comprobaciones.
echo "<p>¿Existe la clave descuento?: ";
var_dump($tieneClave);
echo "</p>";

echo "<p>¿El descuento tiene un valor distinto de null?: ";
var_dump($tieneValor);
echo "</p>";

// Ordenamos la flota de mayor a menor según la autonomía.
// El operador <=> realiza una comparación de tres vías.
usort($flota, function (array $a, array $b): int {
    return $b["autonomia"] <=> $a["autonomia"];
});

// Generamos el contenido del reporte dentro del búfer.
echo "<h1>Reporte de flota EcoDrive</h1>";

echo "<ul>";

foreach ($flota as $vehiculo) {

    // Escapamos los textos antes de insertarlos en el HTML.
    $modelo = htmlspecialchars(
        $vehiculo["modelo"],
        ENT_QUOTES,
        "UTF-8"
    );

    $categoria = htmlspecialchars(
        $vehiculo["categoria"],
        ENT_QUOTES,
        "UTF-8"
    );

    // Mostramos los datos principales de cada vehículo.
    echo "<li>";
    echo "Modelo: {$modelo} | ";
    echo "Categoría: {$categoria} | ";
    echo "Autonomía: {$vehiculo["autonomia"]} km | ";
    echo "Longitud del modelo: {$vehiculo["longitud"]} caracteres";
    echo "</li>";
}

echo "</ul>";

// Preparamos los datos para poder utilizarlos de forma segura en JavaScript.
$datosJS = json_encode(
    $flota,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
);

// Generamos un pequeño bloque de JavaScript con los datos de la flota.
echo "<script>";
echo "const flotaEcoDrive = {$datosJS};";
echo "console.log(flotaEcoDrive);";
echo "</script>";

// Recuperamos el contenido almacenado en el búfer y lo limpiamos.
$reporte = ob_get_clean();

// Mostramos el reporte generado.
echo $reporte;