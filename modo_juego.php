<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seleccionar Modo de Juego</title>
  <!-- icono y estilos -->
  <link rel="icon" href="imagenes/logo de la empresa.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="modo_juego.css">
  <link rel="icon" href="favicon.png" type="image/png" />
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
          <li class="nav-item"><a class="nav-link active" href="modo_juego.php">Crear Partida</a></li>
          <li class="nav-item"><a class="nav-link" href="resultados.php">Resultados</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="registro.php">Registro</a></li>
        </ul>
      </article>
    </section>
  </nav>
</header>

<!-- contenido principal -->
<main class="container text-center my-5">
  <h1 class="mb-4">Selecciona el Modo de Juego</h1>

  <!-- opción un jugador -->
  <form action="crear_partida.php" method="POST" class="mb-4">
    <input type="hidden" name="cantidad" value="1">
    <button type="submit" class="btn btn-primary btn-lg">Un jugador</button>
  </form>

  <!-- opción multijugador -->
  <form action="crear_partida.php" method="POST">
    <label for="cantidad" class="form-label text-white">Cantidad de jugadores:</label>
    <select name="cantidad" id="cantidad" class="form-select w-25 mx-auto my-3">
      <option value="2">2 Jugadores</option>
      <option value="3">3 Jugadores</option>
      <option value="4">4 Jugadores</option>
      <option value="5">5 Jugadores</option>
    </select>
    <button type="submit" class="btn btn-success btn-lg">Multijugador</button>
  </form>

  <!-- volver -->
  <a href="index.php" class="btn btn-secondary mt-4">Volver al Inicio</a>
</main>

<!-- footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
  <small>&copy; 2025 SydneyCorp - UTU Informática</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
