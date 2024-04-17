<?php
// Incluir archivos de configuración, modelos y controladores
require_once __DIR__ . '/../../../config/database.php'; // Archivo de configuración de la base de datos
require_once __DIR__ . '/../../models/commandModel.php'; // Modelo para el comando
require_once __DIR__ . '/../../controllers/CommandController.php'; // Controlador para el comando

// Inicializar la conexión a la base de datos
try {
    $db = new PDO($dsn, $usuario, $contraseña); // Crear una instancia de PDO para la conexión a la base de datos
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurar el modo de error para lanzar excepciones
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage()); // Manejar errores de conexión
}

// Crear una instancia del controlador de comandos pasando la conexión a la base de datos
$commandController = new CommandController($db);

// Manejar la creación de un nuevo comando cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    // Recuperar los datos del formulario
    $command = $_POST['command'];
    $description = $_POST['description'];
    $ayuda = $_POST['ayuda'];
    $ejemplo = $_POST['ejemplo'];
    $imagen = $_POST['imagen'];

    // Validar si algún campo está vacío
    if (empty($command) || empty($description) || empty($ayuda) || empty($imagen) || empty($ejemplo)) {
        $error_message = "Por favor, completa todos los campos.";
    } else {
        // Intentar crear el comando utilizando el controlador
        $result = $commandController->createCommand($command, $description, $ayuda, $imagen, $ejemplo);
        if ($result) {
            // Redirigir a la página de comandos si la creación fue exitosa
            header("Location: index.php?page=commands");
            exit();
        } else {
            $error_message = "Error al crear el comando. Inténtalo de nuevo.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Comando</title>
    <!-- Incluir los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Crear Nuevo Comando</h1>

    <!-- Mostrar mensaje de error si existe -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Formulario para crear un nuevo comando -->
    <form method="POST" action="create.php">
        <div class="form-group">
            <label for="command">Comando:</label>
            <input type="text" class="form-control" id="command" name="command" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="ayuda">Ayuda:</label>
            <textarea class="form-control" id="ayuda" name="ayuda" required></textarea>
        </div>
        <div class="form-group">
            <label for="ejemplo">Ejemplo:</label>
            <textarea class="form-control" id="ejemplo" name="ejemplo" required></textarea>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="text" class="form-control" id="imagen" name="imagen" required>
        </div>

        <!-- Botón para enviar el formulario -->
        <div style="text-align: center; margin-top: 20px;">
            <button type="submit" class="btn btn-primary" name="create">Crear</button>
        </div>
    </form>

    <!-- Enlaces para navegar -->
    <div style="text-align: center; margin-top: 20px;">
        <a class="btn btn-secondary" href="index.php?page=commands">Volver a la lista de comandos</a>
        <a class="btn btn-primary" href="../home/index.php">Volver al inicio</a>
    </div>
</div>
</body>
</html>
