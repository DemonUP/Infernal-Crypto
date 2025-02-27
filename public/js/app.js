  // Ajusta el año en el footer
  document.getElementById('year').textContent = new Date().getFullYear();
    const header = document.querySelector('header');
    const footer = document.querySelector('footer');

// En cada frame, calculamos los límites
    const topBoundary = header.offsetHeight;
    const bottomBoundary = window.innerHeight - footer.offsetHeight;


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

// Crea gotas con velocidades iniciales muy pequeñas
function createDroplets(count) {
    droplets = [];
    for (let i = 0; i < count; i++) {
      droplets.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: 2 + Math.random() * 4,
        // Velocidad inicial reducida (ajusta a tu gusto)
        vx: (Math.random() - 0.5) * 0.25,
        vy: (Math.random() - 0.5) * 0.25,
        color: 'rgba(200, 0, 0, 0.7)'
      });
    }
  }

  // Listener para detectar el movimiento del mouse y aplicar impulso
  window.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX;
    const mouseY = e.clientY;

    droplets.forEach(d => {
      let dx = d.x - mouseX;
      let dy = d.y - mouseY;
      let distance = Math.sqrt(dx * dx + dy * dy);

      if (distance < 100) {
        let angle = Math.atan2(dy, dx);
        let repelForce = (100 - distance) / 100;
        d.vx += Math.cos(angle) * repelForce * 1.5;
        d.vy += Math.sin(angle) * repelForce * 1.5;
      }
    });
  });


  // Función de animación con fricción y rebote
  function animateDroplets() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Calcula límites verticales según la altura de header y footer
    const topBoundary = header.offsetHeight;
    const bottomBoundary = window.innerHeight - footer.offsetHeight;

    for (let d of droplets) {
      // Aplica fricción (se van frenando tras un empujón)
      d.vx *= 0.98;
      d.vy *= 0.98;

      // Asegura una velocidad mínima para que no queden inmóviles
      const speed = Math.sqrt(d.vx * d.vx + d.vy * d.vy);
      const minSpeed = 0.15; // Ajusta este valor a tu gusto
      if (speed < minSpeed) {
        // Mantiene la dirección, pero fija la velocidad mínima
        let angle = Math.atan2(d.vy, d.vx);
        d.vx = Math.cos(angle) * minSpeed;
        d.vy = Math.sin(angle) * minSpeed;
      }

      // Actualiza posición
      d.x += d.vx;
      d.y += d.vy;

      // Rebote en los bordes horizontales
      if (d.x < d.r) {
        d.x = d.r;
        d.vx = -d.vx;
      } else if (d.x > canvas.width - d.r) {
        d.x = canvas.width - d.r;
        d.vx = -d.vx;
      }

      // Rebote en los bordes verticales (entre header y footer)
      if (d.y < topBoundary + d.r) {
        d.y = topBoundary + d.r;
        d.vy = -d.vy;
      } else if (d.y > bottomBoundary - d.r) {
        d.y = bottomBoundary - d.r;
        d.vy = -d.vy;
      }

      // Dibuja la gota
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
    createDroplets(10);
  });

  resizeCanvas();
  createDroplets(100);
  animateDroplets();
