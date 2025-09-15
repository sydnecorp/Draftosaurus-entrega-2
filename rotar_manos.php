<?php
include "conexion.php"; // conexión bd

$partida_id = $_SESSION["partida_id"]; // id de la partida actual

// traer todas las manos de la partida
$sql = "SELECT usuario_id, dino_nombre FROM manos WHERE partida_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $partida_id);
$stmt->execute();
$res = $stmt->get_result();
$manos = [];
while ($row = $res->fetch_assoc()) {
    $manos[$row['usuario_id']][] = $row['dino_nombre']; // guardo dinos por jugador
}
$stmt->close();

// lista de jugadores de la partida (ordenados por id)
$jugadores = [];
$sql = "SELECT usuario_id FROM jugadores WHERE partida_id=? ORDER BY usuario_id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $partida_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) { 
    $jugadores[] = $row['usuario_id']; 
}
$stmt->close();

// borrar todas las manos
$stmt = $conn->prepare("DELETE FROM manos WHERE partida_id=?");
$stmt->bind_param("i", $partida_id);
$stmt->execute();
$stmt->close();

// rotar las manos (cada jugador pasa su mano al siguiente)
for ($i = 0; $i < count($jugadores); $i++) {
    $actual = $jugadores[$i]; // jugador actual
    $siguiente = $jugadores[($i + 1) % count($jugadores)]; // siguiente jugador (circular)
    if (!isset($manos[$actual])) continue;

    // insertar dinos de la mano del actual en el siguiente
    foreach ($manos[$actual] as $dino) {
        $stmt = $conn->prepare("INSERT INTO manos (partida_id, usuario_id, dino_nombre) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $partida_id, $siguiente, $dino);
        $stmt->execute();
        $stmt->close();
    }
}
