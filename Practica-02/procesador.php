<?php

//Declaramos el tipado para el archivo
declare(strict_types= 1);

//Mostramos todos los errores y avisos durante el desarrollo
error_reporting(E_ALL);

//Hacemos visibles los errores en el navegador
ini_set("display_errors",1);

//Recogemos el parámetro "cantidad" enviado mediante GET.comprueba que el valor recibido sea un número entero.
$cantidad = filter_input(INPUT_GET,"cantidad", FILTER_VALIDATE_INT);

// Comprobamos que la cantidad exista, sea un entero válido y sea mayor que cero.
if ($cantidad === false || $cantidad === null || $cantidad <= 0) {
    http_response_code(400);
    // Detenemos la ejecución y mostramos el mensaje de error.
    exit("La cantidad debe ser un número entero positivo.");
}

// Mostramos la información técnica del dato
echo "<pre>";
var_dump($cantidad);
echo "</pre>";
