<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crypto Dashboard - Infernal</title>

  <!-- TailwindCSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Nosifer&display=swap" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <!-- Canvas para gotas de sangre -->
  <canvas id="bloodCanvas"></canvas>

  <!-- ENCABEZADO -->
  <header>
    <div class="container mx-auto">
      <h1>Crypto Dashboard</h1>
      <p>Datos en tiempo real con DemonUP</p>
    </div>
  </header>

  <!-- CONTENIDO PRINCIPAL -->
  <main>
    <!-- Tarjeta de información -->
    <div class="info-card p-6">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <h2 class="text-lg font-semibold">
          Última actualización:
          <span id="last-update" class="font-bold text-red-400">-</span>
        </h2>
        <div class="flex flex-col w-full max-w-sm text-center md:text-right">
          <h2 class="text-lg font-semibold">
            Próxima actualización en:
            <span id="countdown" class="text-red-300 font-bold">-</span>s
          </h2>
          <div class="w-full bg-gray-700 h-3 mt-2 rounded-full overflow-hidden">
            <div id="progress-bar" class="h-3 bg-red-500 rounded-full transition-all duration-500"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabla de criptomonedas -->
    <div class="crypto-table-container">
      <table class="crypto-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cambio 24h</th>
            <th>Market Cap</th>
          </tr>
        </thead>
        <tbody id="crypto-table">
          <tr>
            <td colspan="5" class="text-center p-6 text-lg loading">Cargando datos...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <!-- FOOTER -->
  <footer>
    <p>© <span id="year"></span> Crypto Dashboard - Todos los derechos reservados</p>
  </footer>

  <!-- Script personalizado -->
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
