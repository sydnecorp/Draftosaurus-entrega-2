<?php
session_start(); // inicio de sesión
include "conexion.php"; // conexión bd

$msg = ""; // mensaje de error o info

// si enviaron el form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = trim($_POST["nombre"] ?? "");
  $email  = trim($_POST["email"] ?? "");
  $pass   = $_POST["contrasena"] ?? "";

  // validar que no haya campos vacíos
  if ($nombre === "" || $email === "" || $pass === "") {
    $msg = "Completá todos los campos.";
  } else {
    // insertar en tabla usuarios
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $pass);
    if ($stmt->execute()) {
      $msg = "Registro OK. Ahora iniciá sesión.";
    } else {
      $msg = "Error: " . $conn->error;
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <!-- icono y estilos -->
  <link rel="icon" href="imagenes/logo de la empresa.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="registro.css">
  <link rel="icon" href="favicon.png" type="image/png" />
</head>
<body>

<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <section class="container">
    <a class="navbar-brand" href="index.php">Draftosaurus</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <article class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="crear_partida.php">Crear Partida</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="registro.php">Registro</a></li>
      </ul>
    </article>
  </section>
</nav>

<!-- formulario registro -->
<main>
  <div class="card">
    <h2>Registro</h2>
    <?php if($msg !== ""): ?>
      <div class="alert"><?php echo $msg; ?></div>
    <?php endif; ?>
    <form method="POST" action="registro.php">
      <input type="text" name="nombre" placeholder="Nombre" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <button type="submit">Registrarse</button>
    </form>
    <p><a href="login.php">Ya tengo cuenta</a></p>
  </div>
</main>

<!-- footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
  <small>&copy; 2025 SydneyCorp - UTU Informática</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
