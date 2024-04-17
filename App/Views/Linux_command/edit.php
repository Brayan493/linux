<?php
// Cargar archivos de configuración, modelos y controladores
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../models/commandModel.php';
require_once __DIR__ . '/../../controllers/CommandController.php';

// Inicializar la conexión a la base de datos
try {
    $db = new PDO($dsn, $usuario, $contraseña);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Crear una instancia del controlador de Comandos de Linux pasando la conexión a la base de datos
$commandController = new CommandController($db);

// Obtener el ID del comando de Linux a editar desde la URL
if (isset($_GET['id'])) {
    $command_id = $_GET['id'];

    // Obtener la información del comando de Linux a editar
    $command = $commandController->getCommandById($command_id);

    if (!$command) {
        // Redireccionar a la lista de comandos de Linux si el comando no existe
        header("Location: index.php?page=commands");
        exit();
    }
} else {
    // Redireccionar a la lista de comandos de Linux si no se proporciona un ID válido
    header("Location: index.php?page=commands");
    exit();
}

// Manejar la actualización del comando de Linux cuando se envía el formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $command_name = $_POST['command'];
    $command_description = $_POST['description'];
    $ayuda = $_POST['ayuda'];
    $imagen = $_POST['imagen'];
    $ejemplo = $_POST['ejemplo'];

    // Validación de datos (puedes agregar validaciones más complejas según tus necesidades)
    if (empty($command_name) || empty($command_description) || empty($ayuda) || empty($imagen) || empty($ejemplo)) {
        $error_message = "Por favor, completa todos los campos.";
    } else {
        // Intentar actualizar el comando de Linux
        $result = $commandController->updateCommand($command_id, $command_name, $command_description, $ayuda, $imagen, $ejemplo);
        if ($result) {
            // Redireccionar a la lista de comandos de Linux después de la actualización exitosa
            header("Location: index.php?page=commands");
            exit();
        } else {
            $error_message = "Error al actualizar el comando de Linux. Inténtalo de nuevo.";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Comando de Linux</title>
    <!-- Agrega las bibliotecas de Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1>Editar Comando de Linux</h1>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?php echo $command_id; ?>">
        <div class="form-group">
            <label for="command">Comando:</label>
            <input type="text" class="form-control" id="command" name="command" value="<?php echo $command['command']; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción:</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo $command['description']; ?>" required>
        </div>

        <div class="form-group">
            <label for="ayuda">Ayuda:</label>
            <input type="text" class="form-control" id="ayuda" name="ayuda" value="<?php echo $command['ayuda']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ejemplo">Ejemplo:</label>
            <input type="text" class="form-control" id="ejemplo" name="ejemplo" value="<?php echo $command['ejemplo']; ?>" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="text" class="form-control" id="imagen" name="imagen" value="<?php echo $command['imagen']; ?>" required>
        </div>

        <!-- Otros campos de comando de Linux si los tienes -->

        <div style="text-align: center; margin-top: 20px;">
        <button type="submit" class="btn btn-primary" name="update">Actualizar</button>
        </div>
    </form>

    <div style="text-align: center; margin-top: 20px;">
    <a class="btn btn-secondary" href="index.php?page=commands">Volver a la lista de comandos de Linux</a>
    <a class="btn btn-primary" href="../home/index.php">Volver al inicio</a>
    </div>
</div>
</body>
</html>
