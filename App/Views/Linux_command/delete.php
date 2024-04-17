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

// Verificar si se ha enviado una solicitud POST para eliminar un comando de Linux
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar_comando' && isset($_POST['id'])) {
    $command_id_to_delete = $_POST['id'];
    
    // Llama a la función deleteCommand para eliminar el comando de Linux
    $deleted = $commandController->deleteCommand($command_id_to_delete);
    
    if ($deleted) {
        echo 'Comando de Linux eliminado con éxito'; // Esto se enviará como respuesta al JavaScript
    } else {
        echo 'Error al eliminar el comando de Linux'; // Esto se enviará como respuesta al JavaScript
    }
    exit(); // Detener la ejecución después de manejar la solicitud
}

// Resto del código de tu controlador
?>
