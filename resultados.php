<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Draftosaurus - Resultados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="estilo.css" />
  <link rel="icon" href="imagenes/logo de la empresa.png" type="image/png" />

</head>
<body>

  
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <section class="container">
        <a class="navbar-brand" href="#">Draftosaurus</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <article class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="tablero.php">Tablero</a></li>
            <li class="nav-item"><a class="nav-link active" href="resultados.html">Resultados</a></li>
          </ul>
        </article>
      </section>
    </nav>
  </header>

  
  <main class="container my-5 text-center text-white">
    <h1 class="mb-4">Resultados Finales</h1>

    <section class="table-responsive">
      <table class="table table-bordered table-dark">
        <thead>
          <tr>
            <th>Jugador</th>
            <th>Puntaje</th>
            <th>Dinosaurios en Río</th>
            <th>Bonificación T-Rex</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Ana</td>
            <td>42</td>
            <td>2</td>
            <td>+1</td>
          </tr>
          <tr>
            <td>Tomás</td>
            <td>39</td>
            <td>1</td>
            <td>+1</td>
          </tr>
          <tr>
            <td>Sofía</td>
            <td>44</td>
            <td>0</td>
            <td>+2</td>
          </tr>
        </tbody>
      </table>
    </section>

    <a href="index.html" class="btn btn-success mt-4">Volver al Inicio</a>
  </main>

  
  <footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>&copy; 2025 SydneyCorp - UTU Informática</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
