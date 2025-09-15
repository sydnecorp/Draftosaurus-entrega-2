<?php
session_start(); // inicio sesión

// validar que haya jugadores y turno en sesión
if (!isset($_SESSION["jugadores_ids"]) || !isset($_SESSION["turno_idx"])) {
    http_response_code(400);
    echo "Sesión inválida";
    exit;
}

$jugadores = $_SESSION["jugadores_ids"]; // lista de jugadores
$idx = $_SESSION["turno_idx"]; // turno actual

// pasar al siguiente turno
$idx++;

// si llegamos al final de la lista, volvemos al primero
if ($idx >= count($jugadores)) {
    $idx = 0;
    include "rotar_manos.php"; // rotar las manos entre jugadores
}

$_SESSION["turno_idx"] = $idx; // guardar nuevo turno

echo "ok"; // respuesta para js
