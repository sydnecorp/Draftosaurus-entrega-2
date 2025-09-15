<?php
session_start(); // inicio de sesión
include "conexion.php"; // conexión a la bd

// validar que venga del form
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["cantidad"])) {
    echo "<h2>Error: Debes iniciar la partida desde el formulario del inicio.</h2>";
    echo "<a href='index.php'>Volver al inicio</a>";
    exit;
}

$cantidad = intval($_POST["cantidad"]); // cantidad de jugadores

// crear partida
$stmt = $conn->prepare("INSERT INTO partidas (cantidad_jugadores) VALUES (?)");
$stmt->bind_param("i", $cantidad);
if (!$stmt->execute()) {
    die("Error al crear partida: " . $stmt->error);
}
$partida_id = $stmt->insert_id; // id de la partida
$stmt->close();

// guardar en sesión
$_SESSION["partida_id"]  = $partida_id;
$_SESSION["cantidad"]    = $cantidad;
$_SESSION["turno_idx"]   = 0;
$_SESSION["jugadores_ids"] = [];

// crear jugadores
$jugadores = [];
for ($i = 1; $i <= $cantidad; $i++) {
    $nombre = "Jugador$i";
    $email  = "jugador{$i}_partida{$partida_id}@draftosaurus.com"; // email único
    $pass   = "1234";

    // insertar en usuarios
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $pass);
    if (!$stmt->execute()) {
        die("Error al insertar usuario: " . $stmt->error);
    }
    $usuario_id = $stmt->insert_id;
    $stmt->close();

    $jugadores[] = $usuario_id;

    // insertar en jugadores (relación con partida)
    $stmt = $conn->prepare("INSERT INTO jugadores (partida_id, usuario_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $partida_id, $usuario_id);
    if (!$stmt->execute()) {
        die("Error al insertar jugador en partida: " . $stmt->error);
    }
    $stmt->close();
}

$_SESSION["jugadores_ids"] = $jugadores;

// bolsa de dinos
$bolsa = [];
$tipos = ["T-Rex", "Triceratops", "Velociraptor", "Parasaurio", "Diplodocus", "Estegosaurio"];
foreach ($tipos as $t) {
    for ($i = 0; $i < 10; $i++) {
        $bolsa[] = $t;
    }
}
shuffle($bolsa); // mezclar

// repartir 6 dinos por jugador
foreach ($jugadores as $jugador_id) {
    for ($j = 0; $j < 6; $j++) {
        $dino = array_pop($bolsa);
        $stmt = $conn->prepare("INSERT INTO manos (partida_id, usuario_id, dino_nombre) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $partida_id, $jugador_id, $dino);
        if (!$stmt->execute()) {
            die("Error en INSERT manos: " . $stmt->error);
        }
        $stmt->close();
    }
}

// redirigir al tablero
header("Location: tablero.php");
exit;
