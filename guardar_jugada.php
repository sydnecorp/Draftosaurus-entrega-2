<?php
session_start(); // inicio de sesión
include "conexion.php"; // conexión bd

// validar que la partida exista en sesión
if (!isset($_SESSION["partida_id"]) || !isset($_SESSION["jugadores_ids"]) || !isset($_SESSION["turno_idx"])) {
    die("Error: partida no iniciada.");
}

$partida_id = $_SESSION["partida_id"];
$jugadores  = $_SESSION["jugadores_ids"];
$turno_idx  = $_SESSION["turno_idx"];
$jugador_id = $jugadores[$turno_idx]; // jugador que juega ahora

// datos que vienen por post
$recinto = $_POST["recinto"] ?? "";
$dino    = $_POST["dino"] ?? "";

if ($recinto === "" || $dino === "") {
    die("Error: datos incompletos.");
}

// guardar jugada en la tabla jugadas
$stmt = $conn->prepare("INSERT INTO jugadas (partida_id, usuario_id, recinto_nombre, dino_nombre, turno) 
                        VALUES (?, ?, ?, ?, ?)");
$turno = $turno_idx + 1;
$stmt->bind_param("iissi", $partida_id, $jugador_id, $recinto, $dino, $turno);
if (!$stmt->execute()) {
    die("Error al guardar jugada: " . $stmt->error);
}
$stmt->close();

// borrar el dino jugado de la mano
$stmt = $conn->prepare("DELETE FROM manos 
                        WHERE partida_id=? AND usuario_id=? AND dino_nombre=? 
                        LIMIT 1");
$stmt->bind_param("iis", $partida_id, $jugador_id, $dino);
if (!$stmt->execute()) {
    die("Error al actualizar mano: " . $stmt->error);
}
$stmt->close();

echo "ok"; // respuesta al js
