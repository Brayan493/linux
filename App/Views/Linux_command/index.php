<?php
// Cargar archivos de configuración, modelos y controladores
require_once __DIR__ . '/../../../config/database.php'; // Asegúrate de que este archivo contenga la configuración de la conexión a la base de datos
require_once __DIR__ . '/../../models/commandModel.php';
require_once __DIR__ . '/../../controllers/commandController.php';

// Inicializar la conexión a la base de datos
try {
    $db = new PDO($dsn, $usuario, $contraseña);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Crear una instancia del controlador de Comandos de Linux pasando la conexión a la base de datos
$commandController = new CommandController($db);

// Obtener la lista de comandos de Linux desde la base de datos
$commands = $commandController->getAllCommands();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Comandos de Linux</title>
    <!-- Agrega las bibliotecas de Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Color de fondo principal */
            background-image: url('https://www.transparenttextures.com/patterns/dark-dots.png'); /* Patrón de fondo */
        }
        .long-text {
            text-align: justify;
            overflow-wrap: break-word;
        }
        .card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            z-index: 9999;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .cerrar-btn {
            background: none;
            border: none;
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            color: red;
            font-size: 20px;
        }
        .cerrar-btn span {
            font-weight: bold;
        }
        .fondo-elegante {
            background-color: #f8f9fa; /* Color de fondo elegante */
            background-image: linear-gradient(135deg, #ffffff 0%, #e2e6ea 100%); /* Gradiente de fondo */
        }
        /* Estilos para el menú desplegable */
        .dropdown-menu-left {
        left: auto;
            right: 0;
        }
        /* Ajuste para el menú desplegable */
        .dropdown-menu {
            left: auto !important;
            right: 0 !important;
            margin-top: 5px; /* Agregar margen superior para evitar que se recorten las opciones */
        }
    </style>
</head>
<body class="fondo-elegante">
<h1>Lista de Comandos de Linux</h1>
<div class="input-group mb-3" style="max-width: 250px; margin-left: auto; margin-right: 180px;">
    <input type="text" class="form-control" placeholder="Buscar comando" aria-label="Buscar comando" aria-describedby="button-addon2" id="searchCommand" onkeyup="buscarComando()">
</div>

<!-- Menú desplegable -->
<div class="dropdown" style="position: fixed; top: 50px; right: 20px;">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Opciones
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="../Linux_command/create.php">Crear Nuevo Comando de Linux</a>
        <a class="dropdown-item" href="../home/index.php">Volver al inicio</a>
        <a class="dropdown-item" href="../Linux_command/index.php">Actualizar</a>
    </div>
</div>

<div class="container fondo-elegante">
    <table id="commandTable" class="table">
        <thead>
            <tr>
                <th>Comando</th>
                <th>Descripción</th>
                <th>Ejemplo</th>
                <th>Ayuda</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($commands as $command): ?>
            <tr>
                <td class="long-text"><?php echo $command['command']; ?></td>
                <td class="long-text">
                    <a class="btn btn-secondary" href="#" onclick="mostrarDescripcion(<?php echo $command['id']; ?>)">Ver más</a>
                    <div id="descripcionCard_<?php echo $command['id']; ?>" class="card" style="display: none;">
                        <button onclick="cerrarDescripcion(<?php echo $command['id']; ?>)" class="cerrar-btn"><span>&times;</span></button>
                        <div class="card-header">
                            <h5 class="card-title" id="tituloComando_<?php echo $command['id']; ?>"><?php echo $command['command']; ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="descripcionMostrada_<?php echo $command['id']; ?>"></p>
                        </div>
                    </div>
                </td>
                <td class="long-text">
                    <a class="btn btn-secondary" href="#" onclick="mostrarEjemplo(<?php echo $command['id']; ?>)">Ver más</a>
                    <div id="ejemploCard_<?php echo $command['id']; ?>" class="card" style="display: none;">
                        <button onclick="cerrarEjemplo(<?php echo $command['id']; ?>)" class="cerrar-btn"><span>&times;</span></button>
                        <div class="card-header">
                            <h5 class="card-title" id="tituloComando_<?php echo $command['id']; ?>"><?php echo $command['command']; ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="ejemploMostrado_<?php echo $command['id']; ?>"></p>
                        </div>
                    </div>
                </td>
                <td class="long-text">
                    <a class="btn btn-secondary" href="<?php echo $command['ayuda']; ?>" target="_blank">Ayuda</a>
                </td>
                <td class="long-text">
                    <a class="btn btn-secondary" href="#" onclick="mostrarImagen(<?php echo $command['id']; ?>)">Ver imagen</a>
                    <div id="imagenCard_<?php echo $command['id']; ?>" class="card" style="display: none;">
                        <div class="card-body">
                            <h5 class="card-title"></h5> <!-- Encabezado del nombre del comando -->
                            <button onclick="cerrarImagen(<?php echo $command['id']; ?>)" class="cerrar-btn"><span>&times;</span></button>
                            <img class="card-img-top" src="" alt="Imagen del comando"> <!-- Imagen del comando -->
                        </div>
                    </div>
                </td>
                <td>
                    <a class="btn btn-primary" href="edit.php?id=<?php echo $command['id']; ?>">Editar</a>
                    <a class="btn btn-danger" href="javascript:void(0);" onclick="eliminarComando(<?php echo $command['id']; ?>)">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Agrega el script de Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>

<script>
    function buscarComando() {
        // Obtener el valor del cuadro de texto de búsqueda
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchCommand");
        filter = input.value.trim().toUpperCase(); // Convertir a mayúsculas y eliminar espacios en blanco
        table = document.getElementById("commandTable");
        tr = table.getElementsByTagName("tr");

        // Iterar sobre todas las filas y mostrar las que coincidan con la búsqueda o mostrar todas si el cuadro de búsqueda está vacío
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; // Columna del nombre del comando
            if (td) {
                txtValue = td.textContent || td.innerText;
                // Mostrar la fila si coincide con la búsqueda o si el cuadro de búsqueda está vacío
                if (filter === '' || txtValue.trim().toUpperCase() === filter) {
                    tr[i].style.display = ""; // Mostrar la fila
                } else {
                    tr[i].style.display = "none"; // Ocultar la fila
                }
            }
        }
    }
    function eliminarComando(commandId) {
        if (confirm('¿Estás seguro de que deseas eliminar este comando de Linux?')) {
            // Realizar una solicitud AJAX al controlador PHP
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            // Definir qué hacer cuando la solicitud AJAX se complete
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // La solicitud se completó correctamente
                    var resultado = xhr.responseText;
                    alert(resultado); // Muestra una alerta con la respuesta del servidor
                    // Puedes personalizar esto para mostrar mensajes de éxito o error según tu lógica de controlador
                    // También puedes recargar la página o actualizar la lista de comandos de Linux si es necesario
                } else {
                    // Manejar errores, si es necesario
                    console.error('Error en la solicitud AJAX');
                }
            };
            
            // Enviar la solicitud AJAX
            xhr.send('accion=eliminar_comando&id=' + commandId);
        }
    }
    function mostrarEjemplo(idComando) {
        var command = <?php echo json_encode($commands); ?>;
        var ejemplo = "";
        for (var i = 0; i < command.length; i++) {
            if (command[i]['id'] === idComando) {
                ejemplo = command[i]['ejemplo']; // Utilizamos el nombre de la columna 'ejemplo'
                break;
            }
        }
        document.querySelector('.ejemploMostrado_' + idComando).innerText = ejemplo;
        document.getElementById('ejemploCard_' + idComando).style.display = 'block';
    }
    function cerrarEjemplo(idComando) {
        document.getElementById('ejemploCard_' + idComando).style.display = 'none';
    }
    function mostrarDescripcion(idComando) {
        var command = <?php echo json_encode($commands); ?>;
        var descripcion = "";
        for (var i = 0; i < command.length; i++) {
            if (command[i]['id'] === idComando) {
                descripcion = command[i]['description'];
                break;
            }
        }
        document.querySelector('.descripcionMostrada_' + idComando).innerText = descripcion;
        document.getElementById('descripcionCard_' + idComando).style.display = 'block';
    }

    function cerrarDescripcion(idComando) {
        document.getElementById('descripcionCard_' + idComando).style.display = 'none';
    }

    function mostrarImagen(idComando) {
        var command = <?php echo json_encode($commands); ?>;
        var nombreComando = "";
        var imagen = "";
        for (var i = 0; i < command.length; i++) {
            if (command[i]['id'] === idComando) {
                nombreComando = command[i]['command']; // Obtener el nombre del comando
                imagen = command[i]['imagen']; // Obtener la URL de la imagen
                break;
            }
        }
        // Construir el ID único de la tarjeta de imagen
        var imagenCardId = 'imagenCard_' + idComando;
        // Actualizar el nombre del comando como encabezado dentro de la tarjeta
        document.querySelector('#' + imagenCardId + ' h5.card-title').innerText = nombreComando;
        // Actualizar la imagen dentro de la tarjeta
        document.querySelector('#' + imagenCardId + ' img.card-img-top').src = imagen;
        // Mostrar la tarjeta de imagen específica
        document.getElementById(imagenCardId).style.display = 'block';
    }

    function cerrarImagen(idComando) {
        // Construir el ID único de la tarjeta de imagen
        var imagenCardId = 'imagenCard_' + idComando;
        // Ocultar la tarjeta de imagen específica
        document.getElementById(imagenCardId).style.display = 'none';
    }
</script>
