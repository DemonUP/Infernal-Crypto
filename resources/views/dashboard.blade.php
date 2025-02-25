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

  <!-- Fuentes: Montserrat (cuerpo) y Nosifer (título infernal) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Nosifer&display=swap"
    rel="stylesheet"
  >

  <style>
    /************************************
      FONDO PRINCIPAL Y ESTRUCTURA
    *************************************/
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow-x: hidden;
    }
    body {
      font-family: 'Montserrat', sans-serif;
      color: #dddddd;
      position: relative;

      /* Degradado infernal más oscuro */
      background: linear-gradient(45deg, #0b0000, #300000, #0b0000);
      background-size: 600% 600%;
      animation: backgroundCycle 20s ease infinite;
    }
    @keyframes backgroundCycle {
      0%   { background-position: 0% 50%; }
      50%  { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Textura sutil sobre el degradado */
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url("https://www.transparenttextures.com/patterns/asfalt-dark.png");
      opacity: 0.1;
      pointer-events: none;
      z-index: -1;
    }

    /* Canvas para gotas de sangre, detrás de todo el contenido */
    #bloodCanvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -2;
    }

    /************************************
      ENCABEZADO
    *************************************/
    header {
      background: #200000;
      box-shadow: 0 4px 10px rgba(0,0,0,0.5);
      text-align: center;
      padding: 2.5rem 1rem;
    }
    header h1 {
      font-family: 'Nosifer', cursive;
      font-size: 3rem;
      color: #ff2222; /* Rojo intenso */
      text-shadow: 0 0 8px #ff2222, 0 0 12px #ff2222;
      margin: 0;
    }
    header p {
      margin-top: 1rem;
      font-size: 1.25rem;
      color: #e0e0e0;
    }

    /************************************
      CONTENEDOR PRINCIPAL
    *************************************/
    main {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 1rem;
      position: relative;
    }

    /************************************
      TARJETA DE INFORMACIÓN
    *************************************/
    .info-card {
      background: rgba(25, 0, 0, 0.9);
      border: 1px solid #440000;
      border-radius: 0.75rem;
      box-shadow: 0 0 15px rgba(255, 0, 0, 0.3);
      margin-bottom: 2rem;
    }

    /************************************
      TABLA DE CRIPTOS
    *************************************/
    .crypto-table-container {
      background: rgba(25, 0, 0, 0.9);
      border: 1px solid #440000;
      border-radius: 0.75rem;
      box-shadow: 0 0 15px rgba(255, 0, 0, 0.3);
      overflow: hidden;
    }
    .crypto-table {
      width: 100%;
      border-collapse: collapse;
    }
    .crypto-table thead tr {
      background-color: #2a0000;
      border-bottom: 1px solid #440000;
    }
    .crypto-table thead th {
      color: #f5f5f5;
      font-size: 0.875rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      padding: 0.75rem;
    }
    .crypto-table tbody tr {
      border-bottom: 1px solid #440000;
      transition: background 0.2s;
    }
    .crypto-table tbody tr:hover {
      background: rgba(255, 40, 40, 0.15);
    }
    .crypto-table tbody td {
      padding: 0.75rem;
      font-size: 0.875rem;
    }

    /************************************
      ANIMACIONES DE PRECIOS
    *************************************/
    .price-up {
      animation: flash-green 1s ease-in-out;
    }
    .price-down {
      animation: flash-red 1s ease-in-out;
    }
    @keyframes flash-green {
      0% { background-color: #10b981; color: #000; }
      100% { background-color: transparent; color: inherit; }
    }
    @keyframes flash-red {
      0% { background-color: #ef4444; color: #000; }
      100% { background-color: transparent; color: inherit; }
    }

    /************************************
      ANIMACIÓN DE CARGA
    *************************************/
    .loading {
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%   { opacity: 0.5; }
      50%  { opacity: 1; }
      100% { opacity: 0.5; }
    }

    /************************************
      FOOTER
    *************************************/
    footer {
      background: #200000;
      text-align: center;
      color: #cccccc;
      padding: 1rem 0;
    }

    /************************************
      SCROLLBAR PERSONALIZADO
    *************************************/
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #200000;
    }
    ::-webkit-scrollbar-thumb {
      background: #700000;
      border-radius: 9999px;
    }
  </style>
</head>
<body>
  <!-- Canvas para las gotas de sangre, detrás de todo -->
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
    <!-- Tarjeta de información (última actualización y temporizador) -->
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
            <td colspan="5" class="text-center p-6 text-lg loading">
              Cargando datos...
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <!-- FOOTER -->
  <footer>
    <p>© <span id="year"></span> Crypto Dashboard - Todos los derechos reservados</p>
  </footer>

  <!-- ===================== SCRIPTS ===================== -->
  <script>
    // Ajusta el año en el footer
    document.getElementById('year').textContent = new Date().getFullYear();

    let countdown = 0;
    let cryptoData = {};

    function updateCountdown() {
      if (countdown > 0) {
        countdown--;
      } else {
        loadCryptos();
      }
      $("#countdown").text(countdown);
      $("#progress-bar").css("width", `${(countdown / 60) * 100}%`);
    }

    function animateValue(element, start, end, duration) {
      let range = end - start;
      let startTime = new Date().getTime();
      let endTime = startTime + duration;
      let step = function () {
        let currentTime = new Date().getTime();
        let progress = Math.min((currentTime - startTime) / duration, 1);
        element.textContent = "$" + (start + progress * range).toFixed(2);
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    }

    function loadCryptos() {
      $.getJSON('/api/cryptos', function(response) {
        if (!response.cryptos || !Array.isArray(response.cryptos)) {
          console.error("Error: La API no devolvió un array válido", response);
          return;
        }

        $("#last-update").text(new Date(response.last_update).toLocaleTimeString());
        countdown = response.time_remaining;
        $("#countdown").text(countdown);

        $("#crypto-table").html("");

        response.cryptos.forEach((crypto, index) => {
          let symbol = crypto.symbol.toLowerCase();
          let priceChangeClass = crypto.changePercent24Hr < 0 ? 'text-red-500' : 'text-green-500';
          let newPrice = parseFloat(crypto.priceUsd).toFixed(2);
          let newChange = parseFloat(crypto.changePercent24Hr).toFixed(2);
          let newMarketCap = parseFloat(crypto.marketCapUsd).toLocaleString();

          let priceAnimationClass = "";
          if (cryptoData[symbol] && cryptoData[symbol] !== newPrice) {
            priceAnimationClass = cryptoData[symbol] < newPrice ? "price-up" : "price-down";
          }
          cryptoData[symbol] = newPrice;

          let row = $(`
            <tr class="transition duration-300 ease-in-out">
              <td class="p-4 text-sm font-semibold">${index + 1}</td>
              <td class="p-4 flex items-center text-sm">
                <img
                  src="https://static.coincap.io/assets/icons/${symbol}@2x.png"
                  alt="${crypto.name}"
                  class="w-6 h-6 mr-2"
                >
                <span class="font-semibold">${crypto.name}</span>
                <span class="text-gray-400 ml-2">(${crypto.symbol})</span>
              </td>
              <td class="crypto-price p-4 text-sm font-semibold ${priceAnimationClass}">$${newPrice}</td>
              <td class="crypto-change p-4 text-sm font-semibold ${priceChangeClass}">${newChange}%</td>
              <td class="p-4 text-sm font-semibold">$${newMarketCap}</td>
            </tr>
          `);

          $("#crypto-table").append(row);
        });
      }).fail(function(error) {
        console.error("Error al obtener datos de la API", error);
      });
    }

    // Inicializa la carga de datos y el temporizador
    loadCryptos();
    setInterval(updateCountdown, 1000);

    /*******************************************************
      GOTAS DE SANGRE (Canvas al fondo)
    *******************************************************/
    const canvas = document.getElementById('bloodCanvas');
    const ctx = canvas.getContext('2d');
    let droplets = [];

    function resizeCanvas() {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    }

    function createDroplets(count) {
      droplets = [];
      for (let i = 0; i < count; i++) {
        droplets.push({
          x: Math.random() * canvas.width,
          y: Math.random() * canvas.height,
          r: 2 + Math.random() * 4, // Radio entre 2 y 6
          vx: (Math.random() - 0.5) * 0.3,
          vy: (Math.random() - 0.5) * 0.3,
          color: 'rgba(200, 0, 0, 0.7)'
        });
      }
    }

    function animateDroplets() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      for (let d of droplets) {
        d.x += d.vx;
        d.y += d.vy;

        // Rebote suave o wrap-around
        if (d.x < -d.r) d.x = canvas.width + d.r;
        if (d.x > canvas.width + d.r) d.x = -d.r;
        if (d.y < -d.r) d.y = canvas.height + d.r;
        if (d.y > canvas.height + d.r) d.y = -d.r;

        ctx.beginPath();
        ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2, false);
        ctx.fillStyle = d.color;
        ctx.fill();
      }

      requestAnimationFrame(animateDroplets);
    }

    // Ajustar y crear gotas
    window.addEventListener('resize', () => {
      resizeCanvas();
      createDroplets(30);
    });

    resizeCanvas();
    createDroplets(30);
    animateDroplets();
  </script>
</body>
</html>
