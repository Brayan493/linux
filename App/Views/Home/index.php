<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <!-- Incluir los archivos CSS de Bootstrap desde BootstrapCDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
        
        /* Estilos para los paneles */
        .container {
            display: flex;
            width: 90vw;
        }
        .panel {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 80vh;
            border-radius: 50px;
            color: #fff;
            cursor: pointer;
            flex: 0.5;
            margin: 10px;
            position: relative;
            -webkit-transition: all 700ms ease-in;
        }

        .panel h3 {
            font-size: 24px;
            position: absolute;
            bottom: 20px;
            left: 20px;
            margin: 0;
            opacity: 0;
        }

        .panel.active {
            flex: 5;
        }

        .panel.active h3 {
            opacity: 1;
            transition: opacity 0.3s ease-in 0.4s;
        }

        /* Estilos responsivos */
        @media (max-width: 480px) {
            .container {
                width: 100vw;
            }
            .panel:nth-of-type(4),
            .panel:nth-of-type(5){
                display: none;
            }
        }
        .introduccion {
            text-align: justify;
            font-size: 15px;
        }
    </style>
</head>
<body>
<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Mi Aplicación</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../linux_command/index.php">Comandos de Linux</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container mt-4">
    <h1>Bienvenido a Mi Aplicación</h1>
</div>
<div class="container mt-4">
<h2 class="introduccion">
        Oscar Barreto, encargado del desarrollo del backend, aportó su experiencia y habilidades para diseñar 
        y construir la lógica del servidor. Su enfoque meticuloso en la implementación de las funcionalidades del 
        backend garantizó un rendimiento óptimo y una sólida comunicación entre el servidor y el cliente.<br>
        <br>
         Nathalia  Vega García, con su destreza en el frontend, dio vida a la interfaz de usuario con creatividad y atención al detalle. 
        Desde la creación de diseños atractivos hasta la implementación de elementos interactivos, su trabajo hizo que la experiencia 
        del usuario fuera intuitiva y agradable. <br>
        <br>
        Brayan Jesus capacho, experto en bases de datos, desempeñó un papel fundamental al diseñar 
        y administrar la estructura de la base de datos. Su dedicación al modelado de datos y la optimización del rendimiento garantizó 
        una gestión eficiente de la información y una escalabilidad adecuada para el sistema.
    </h2>
</div>

<!-- Paneles con imágenes -->
<div class="container">
    <div class="panel active" style="background-image: url('https://www.redeszone.net/app/uploads-redeszone.net/2014/12/IPTraf_Linux_foto_6.png?x=1350&quality=80')">
    </div>
    <div class="panel" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/Linux_5.13.5_boot_message_screenshot.png/1350px-Linux_5.13.5_boot_message_screenshot.png')">
    </div>
    <div class="panel" style="background-image: url('https://www.mundodeportivo.com/urbantecno/hero/2022/01/comandos-utiles-hardware.jpg?width=1350&aspect_ratio=80&format=nowebp')">
        
    </div>
    <div class="panel" style="background-image: url('https://miro.medium.com/v2/resize:fit:1350/1*vgMiTstFJG8nYmTSY0Od_g.png')">
       
    </div>
    <div class="panel" style="background-image: url('https://i.ytimg.com/vi/6Z4LWz5qdqU/maxresdefault.jpg')">
        
    </div>
</div>

<!-- Incluir los archivos JS de Bootstrap desde BootstrapCDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script JavaScript para manejar la interacción con los paneles
    const panels = document.querySelectorAll('.panel');
    panels.forEach(panel => {
        panel.addEventListener('click', () => {
            removeActiveClasses(); // Elimina la clase 'active' de todos los paneles
            panel.classList.add('active'); // Agrega la clase 'active' al panel seleccionado
        });
    });

    // Función para eliminar la clase 'active' de todos los paneles
    function removeActiveClasses() {
        panels.forEach(panel => {
            panel.classList.remove('active');
        });
    }
</script>
</body>
</html>
