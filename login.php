<?php
session_start(); // inicio de sesión
include "conexion.php"; // conexión bd

$msg = ""; // mensaje de error o info

// si enviaron el form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $pass  = $_POST["contrasena"] ?? "";

  // buscar usuario por email
  $stmt = $conn->prepare("SELECT usuario_id, nombre, contrasena FROM usuarios WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $res = $stmt->get_result();

  if ($res->num_rows === 1) {
    $u = $res->fetch_assoc();
    // comparar contraseña (texto plano en este caso)
    if ($pass === $u["contrasena"]) {
      // guardar datos en sesión
      $_SESSION["usuario_id"] = $u["usuario_id"];
      $_SESSION["nombre"]     = $u["nombre"];
      header("Location: index.php"); // redirigir al inicio
      exit;
    } else {
      $msg = "Contraseña incorrecta.";
    }
  } else {
    $msg = "Usuario no encontrado.";
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="icon" href="imagenes/logo de la empresa.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
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

<!-- formulario login -->
<main>
  <div class="card">
    <h2>Iniciar Sesión</h2>
    <?php if($msg !== ""): ?>
      <div class="alert"><?php echo $msg; ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <button type="submit">Entrar</button>
    </form>
    <p><a href="registro.php">Crear cuenta</a></p>
  </div>
</main>

<!-- footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
  <small>&copy; 2025 SydneyCorp - UTU Informática</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
