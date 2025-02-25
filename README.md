# 🚀 Crypto Dashboard - Infernal Edition 🔥

### 🔴 Un dashboard de criptomonedas en tiempo real con un estilo oscuro e infernal 🔴

---

## 📌 Descripción
Este **Crypto Dashboard** muestra en tiempo real las **10 principales criptomonedas** del mercado con precios actualizados automáticamente cada minuto. Implementa un diseño oscuro con animaciones de **sangre flotante**, un temporizador sincronizado con el backend y un **sistema de caché** para optimizar el rendimiento.

---

## 📷 Captura de Pantalla
![Crypto Dashboard](https://via.placeholder.com/1200x600?text=Crypto+Dashboard+Preview)

---

## 🛠️ Tecnologías Usadas
✅ **Laravel 10** - Backend robusto con caché y logs  
✅ **CoinCap API** - Datos de criptomonedas en tiempo real  
✅ **TailwindCSS** - Diseño moderno y responsive  
✅ **jQuery** - Interacción dinámica con AJAX  
✅ **Canvas API** - Animaciones de sangre flotante  

---

## ⚙️ Instalación
### 1️⃣ Clona el repositorio
```sh
git clone https://github.com/tu-usuario/crypto-dashboard.git
cd crypto-dashboard
```

### 2️⃣ Instala las dependencias de Laravel
```sh
composer install
npm install
```

### 3️⃣ Configura el entorno
Copia el archivo `.env.example` y renómbralo a `.env`  
Edita el archivo y asegúrate de configurar los valores de caché y la API.

```sh
php artisan key:generate
```

### 4️⃣ Levanta el servidor
```sh
php artisan serve
```

Abre en tu navegador: `http://127.0.0.1:8000`

---

## 📊 Estructura del Proyecto
```
crypto-dashboard/
│── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CryptoController.php   # Lógica del backend
│── public/
│   ├── css/
│   │   ├── app.css                   # Estilos de Tailwind y animaciones
│   ├── js/
│   │   ├── app.js                    # Lógica del frontend con jQuery
│── resources/
│   ├── views/
│   │   ├── dashboard.blade.php        # Vista principal del dashboard
│── routes/
│   ├── web.php                        # Rutas de Laravel
│── .env
│── README.md
```

---

## 🔗 Rutas Importantes
| Método | URL               | Descripción |
|--------|------------------|-------------|
| `GET`  | `/`              | Muestra el dashboard |
| `GET`  | `/api/cryptos`   | Retorna datos de criptomonedas |

---

## 📦 Funciones Destacadas
✔️ **Carga de datos en tiempo real** (cada minuto, sin bloquear la API)  
✔️ **Caché de datos en Laravel** para evitar llamadas innecesarias a la API  
✔️ **Animaciones de precios** con efecto de parpadeo en cambios  
✔️ **Temporizador de actualización** completamente sincronizado con el backend  
✔️ **Animaciones en Canvas** con gotas de sangre flotante  
✔️ **Diseño responsive** optimizado para dispositivos móviles  

---

## 🔥 Mejoras a Futuro
🔹 Soporte para **más criptomonedas** y filtros personalizados  
🔹 Gráficos dinámicos con **Chart.js**  
🔹 Sistema de **usuarios y autenticación** para personalizar dashboards  
🔹 WebSockets para **actualización en tiempo real sin AJAX**  

---

## 💡 Contribuciones
¿Tienes ideas para mejorar este proyecto? ¡Siéntete libre de hacer un **fork** y enviar un **pull request**!  
Para reportar errores, abre un **issue** en GitHub.  

---

## 📜 Licencia
Este proyecto está bajo la licencia **MIT**.  

📌 **Desarrollado con pasión y fuego 🔥 por [Tu Nombre]**  

---

🎉 ¡Gracias por visitar **Crypto Dashboard - Infernal Edition**! 🚀
