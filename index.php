<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Draftosaurus - Inicio</title>
  <!-- icono de la página -->
  <link rel="icon" href="imagenes/logo de la empresa.png" type="image/png" />
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- estilos propios -->
  <link rel="stylesheet" href="estilo.css" />
  <link rel="icon" href="favicon.png" type="image/png" />
</head>
<body>
  
<!-- dinosaurios decorativos -->
<img src="imagenes/1.png" alt="Dino izquierdo" class="dino-left" />
<img src="imagenes/3.png" alt="Dino derecho" class="dino-right" />

<!-- barra de navegación -->
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <section class="container">
      <a class="navbar-brand" href="index.php">Draftosaurus</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <article class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="modo_juego.php">Crear Partida</a></li>
          <li class="nav-item"><a class="nav-link" href="resultados.php">Resultados</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="registro.php">Registro</a></li>
        </ul>
      </article>
    </section>
  </nav>
</header>

<!-- contenido principal -->
<main class="container my-5 d-flex justify-content-center align-items-center">
  <section class="d-flex align-items-center">
    <article class="text-center">
      <h1 class="mb-4">Bienvenido a Draftosaurus</h1>
      <p class="lead">¡Construí tu propio parque de dinosaurios y ganá la partida!</p>
      <img src="imagenes/Logo-Draftosaurus.png" alt="Logo Draftosaurus" class="img-fluid my-4" style="max-width: 300px;" />
      <div>
        <!-- botón para empezar -->
        <a href="modo_juego.php" class="btn btn-success btn-lg">Comenzar</a>
      </div>
      <!-- link a reglas -->
      <a href="reglas.html" class="btn btn-success btn-lg">Reglas</a>
    </article>
  </section>
</main>

<!-- pie de página -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
  <small>&copy; 2025 SydneyCorp - UTU Informática</small>
</footer>

<!-- js de bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
