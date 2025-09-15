<?php
session_start();
include "conexion.php";

// si no hay partida activa, volver al inicio
if (!isset($_SESSION["partida_id"])) { header("Location: index.php"); exit; }

$partida_id = $_SESSION["partida_id"];

// si no hay jugadores cargados en sesión, los traemos de la BD
if (!isset($_SESSION["jugadores_ids"]) || !is_array($_SESSION["jugadores_ids"]) || count($_SESSION["jugadores_ids"]) === 0) {
  $_SESSION["jugadores_ids"] = [];
  $stmt = $conn->prepare("SELECT usuario_id FROM jugadores WHERE partida_id=? ORDER BY usuario_id");
  $stmt->bind_param("i", $partida_id);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) { $_SESSION["jugadores_ids"][] = $r["usuario_id"]; }
  $stmt->close();
  $_SESSION["turno_idx"] = 0; // arranca jugador 1
}

$jugadores_ids = $_SESSION["jugadores_ids"];
$turno_idx     = $_SESSION["turno_idx"] ?? 0;

// jugador actual según el turno
$jugador_id = $jugadores_ids[$turno_idx] ?? $jugadores_ids[0];

// nombre del jugador
$stmt = $conn->prepare("SELECT nombre FROM usuarios WHERE usuario_id=?");
$stmt->bind_param("i", $jugador_id);
$stmt->execute();
$res = $stmt->get_result();
$nombre_jugador = ($row = $res->fetch_assoc()) ? $row["nombre"] : ("Jugador ".($turno_idx+1));
$stmt->close();

// jugadas que ya hizo este jugador
$jugadas = [];
$sql = "SELECT recinto_nombre, dino_nombre FROM jugadas WHERE partida_id=? AND usuario_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $partida_id, $jugador_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) { $jugadas[] = $row; }
$stmt->close();

// dinos que tiene en la mano este jugador
$dinos_mano = [];
$sql = "SELECT dino_nombre FROM manos WHERE partida_id=? AND usuario_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $partida_id, $jugador_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) { $dinos_mano[] = $row['dino_nombre']; }
$stmt->close();

// imágenes asociadas a cada dino
$IMG_MAP = [
  "T-Rex"        => "rojo.png",
  "Triceratops"  => "verde.png",
  "Velociraptor" => "naranja.png",
  "Parasaurio"   => "amarillo.png",
  "Diplodocus"   => "azul.png",
  "Estegosaurio" => "rosa.png"
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Draftosaurus - Tablero</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="tablero.css" />
  <link rel="icon" href="imagenes/logo de la empresa.png" type="image/png" />
</head>
<body>

<!-- navbar -->
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <section class="container">
      <a class="navbar-brand" href="index.php">Draftosaurus</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <article class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link active" href="tablero.php">Tablero</a></li>
          <li class="nav-item"><a class="nav-link" href="resultados.php">Resultados</a></li>
        </ul>
      </article>
    </section>
  </nav>
</header>

<main class="container my-5">
  <h1 class="text-white text-center mb-2">Tablero del Parque</h1>
  <h4 class="text-warning text-center mb-4">
    Turno de: <?php echo htmlspecialchars($nombre_jugador); ?> (Jugador <?php echo $turno_idx+1; ?>)
  </h4>

  <div class="row">
    <!-- tablero -->
    <div class="col-md-8 text-center">
      <section class="tablero-wrap">
        <img src="imagenes/tablero.jpg" alt="Tablero de Draftosaurus" class="img img-fluid rounded shadow" />

        <!-- recintos -->
        <div class="recinto" style="left:5%; top:10%; width:32%; height:20%;" data-zone="Bosque Izq 1" data-side="izq" data-has-trex="false" data-occupied="0"></div>
        <div class="recinto" style="left:5%; top:37%; width:25%; height:20%;" data-zone="Bosque Izq 2" data-side="izq" data-has-trex="false" data-occupied="0"></div>
        <div class="recinto" style="left:10%; top:60%; width:25%; height:23%;" data-zone="Roca Izq" data-side="izq" data-has-trex="false" data-occupied="0"></div>
        <div class="recinto" style="left:65%; top:11%; width:15%; height:15%;" data-zone="Bosque Der T-Rex" data-side="der" data-has-trex="true" data-occupied="0"></div>
        <div class="recinto" style="left:60%; top:35%; width:35%; height:20%;" data-zone="Roca Der 1" data-side="der" data-has-trex="false" data-occupied="0"></div>
        <div class="recinto" style="left:70%; top:60%; width:25%; height:20%;" data-zone="Roca Der 2" data-side="der" data-has-trex="false" data-occupied="0"></div>
        <div class="recinto" style="left:40%; top:5%; width:20%; height:90%;" data-zone="Rio" data-side="centro" data-has-trex="false" data-occupied="0"></div>
      </section>

      <!-- dado -->
      <section class="mt-4">
        <h2 class="text-white">Dado</h2>
        <img id="dado-img" src="imagenes/huella.png" alt="Dado" class="img-dado" />
        <br />
        <button class="btn btn-dark mt-3" onclick="girarDado()">Girar Dado</button>
      </section>
    </div>

    <!-- dinos en mano -->
    <div class="col-md-4">
      <section class="mt-3 text-white text-center">
        <h5>Dinosaurios disponibles</h5>
        <article class="d-flex flex-wrap justify-content-center gap-2">
          <?php foreach ($dinos_mano as $d): 
                $src = isset($IMG_MAP[$d]) ? $IMG_MAP[$d] : (strtolower($d).".png"); ?>
            <img src="imagenes/<?php echo $src; ?>"
                 alt="<?php echo htmlspecialchars($d); ?>"
                 class="dino m-2"
                 draggable="true" />
          <?php endforeach; ?>
        </article>
      </section>
    </div>
  </div>

  <div class="mt-4">
    <button class="btn btn-primary" onclick="location.href='index.php'">Volver al Inicio</button>
  </div>
</main>

<footer class="bg-dark text-white text-center py-3 mt-auto">
  <small>&copy; 2025 SydneyCorp - UTU Informática</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // mapeo de imágenes
  const IMG_MAP = <?php echo json_encode($IMG_MAP); ?>;

  // caras del dado
  const CARAS = [
    { id: "trex",   img: "imagenes/trex.png",   nombre: "T-Rex" },
    { id: "huella", img: "imagenes/huella.png", nombre: "Huella (vacío)" },
    { id: "bosque", img: "imagenes/bosque.png", nombre: "Bosque" },
    { id: "roca",   img: "imagenes/piedra.png", nombre: "Roca" },
    { id: "banos",  img: "imagenes/baños.png",  nombre: "Derecha del río" },
    { id: "taza",   img: "imagenes/taza.png",   nombre: "Izquierda del río" }
  ];

  let currentRule;
  let turnoActivo = false;

  // tirar dado
  function girarDado() {
    const dado = document.getElementById("dado-img");
    dado.classList.add("girando");
    setTimeout(() => {
      const i = Math.floor(Math.random() * CARAS.length);
      currentRule = CARAS[i];
      dado.src = currentRule.img;
      dado.alt = "Dado: " + currentRule.nombre;
      dado.classList.remove("girando");
      turnoActivo = true;
      alert("Tiraste el dado. Ahora colocá un dinosaurio.");
    }, 300);
  }

  // normalizar strings (para acentos y mayúsculas)
  const normalize = (s) => s.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

  // validación de reglas
  function puedeColocar(recinto, regla) {
    const zone = recinto.dataset.zone;
    const side = recinto.dataset.side;
    const ocupado = recinto.dataset.occupied === "1";
    const hasTrex = recinto.dataset.hasTrex === "true";
    const nz = normalize(zone);

    if (regla.id === "trex")   return !hasTrex;
    if (regla.id === "huella") return !ocupado;
    if (regla.id === "bosque") return nz.includes("bosque");
    if (regla.id === "roca")   return nz.includes("roca");
    if (regla.id === "banos")  return side === "der";
    if (regla.id === "taza")   return side === "izq";
    if (regla.id === "rio")    return nz === "rio";
    return true;
  }

  document.addEventListener("DOMContentLoaded", () => {
    // cargar jugadas anteriores
    const jugadas = <?php echo json_encode($jugadas); ?>;
    jugadas.forEach(j => {
      const recinto = document.querySelector(`[data-zone='${CSS.escape(j.recinto_nombre)}']`);
      if (recinto) {
        const img = document.createElement("img");
        const file = IMG_MAP[j.dino_nombre] || (j.dino_nombre.toLowerCase() + ".png");
        img.src = "imagenes/" + file;
        img.className = "dino m-1";
        recinto.appendChild(img);
        recinto.dataset.occupied = "1";
      }
    });

    // drag & drop en los recintos
    const recintos = document.querySelectorAll(".recinto");
    recintos.forEach(r => {
      r.addEventListener("dragover", e => e.preventDefault());
      r.addEventListener("drop", e => {
        e.preventDefault();
        if (!turnoActivo) {
          alert("Ya colocaste un dinosaurio. Tirar el dado para el siguiente turno.");
          return;
        }
        if (r.dataset.occupied === "1") {
          alert("Este recinto ya tiene un dinosaurio");
          return;
        }
        if (!puedeColocar(r, currentRule)) {
          alert("No podés poner acá");
          return;
        }
        const dino = document.querySelector(".dragging");
        if (dino) {
          r.appendChild(dino);
          r.dataset.occupied = "1";
          dino.classList.remove("dragging");
          // guardar jugada
          fetch("guardar_jugada.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "recinto=" + encodeURIComponent(r.dataset.zone) +
                  "&dino=" + encodeURIComponent(dino.alt)
          }).then(() => {
            turnoActivo = false;
            fetch("siguiente_turno.php").then(() => location.reload());
          });
        }
      });
    });

    // drag en los dinos
    const dinos = document.querySelectorAll(".dino");
    dinos.forEach(dino => {
      dino.addEventListener("dragstart", () => dino.classList.add("dragging"));
      dino.addEventListener("dragend",   () => dino.classList.remove("dragging"));
    });
  });
</script>
</body>
</html>
