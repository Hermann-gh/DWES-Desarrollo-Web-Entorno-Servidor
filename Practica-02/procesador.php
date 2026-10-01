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

/**
 * Procesa las líneas de una reserva y calcula el importe total.
 *
 * @param array $reservas Líneas de vehículos incluidas en la reserva.
 * @return float Importe total de la reserva.
 * @throws InvalidArgumentException Si la lista de reservas está vacía.
 */
function procesarReserva(array $reservas): float
{
   // Comprobamos si la lista de reservas está vacía.
    if (empty($reservas)) {
        // Lanzamos una excepción porque no se puede procesar una reserva sin elementos.
        throw new InvalidArgumentException("La lista de reservas no puede estar vacía.");
    }
    // Inicializamos el importe total de la reserva.
    $total = 0.0;
    // Recorremos todas las líneas de la reserva.
    foreach ($reservas as $reserva) {
    // Sumamos el importe de cada línea al total.
    $total += $reserva;
}
    // Devolvemos el importe total calculado.
    return $total;
}

try {
    // Creamos una lista de importes de reserva de prueba.
    $reservas = [60, 50];
    // Intentamos procesar la reserva.
    $total = procesarReserva($reservas);
    // Mostramos el resultado.
    echo "<p>Total de la reserva: {$total} €</p>";
    // Determinamos la categoría económica según el importe total.
    $categoria = $total >= 100
        ? "Descuento"
        : "Suplemento";
    // Mostramos la categoría obtenida.
    echo "<p>Categoría de la reserva: {$categoria}</p>";
} catch (InvalidArgumentException $e) {
    // Capturamos la excepción producida cuando la lista está vacía.
    echo "<p>Error al procesar la reserva: {$e->getMessage()}</p>";
}
