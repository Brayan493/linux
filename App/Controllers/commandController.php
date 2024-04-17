<?php
class CommandController {
    private $db; // Propiedad privada para almacenar la conexión de base de datos

    public function __construct($db) {
        $this->db = $db; // Constructor que recibe una conexión de base de datos y la asigna a la propiedad privada $db
    }

    // Método para obtener todos los comandos de la base de datos
    public function getAllCommands() {
        $query = "SELECT * FROM linux_commands"; // Consulta SQL para seleccionar todos los comandos
        $result = $this->db->query($query); // Ejecutar la consulta
        return $result->fetchAll(PDO::FETCH_ASSOC); // Devolver el resultado como un array asociativo
    }

    // Método para obtener un comando por su ID
    public function getCommandById($id) {
        $query = "SELECT * FROM linux_commands WHERE id = :id"; // Consulta SQL para seleccionar un comando por su ID
        $stmt = $this->db->prepare($query); // Preparar la consulta
        $stmt->bindParam(":id", $id, PDO::PARAM_INT); // Enlazar el parámetro :id con el valor proporcionado
        $stmt->execute(); // Ejecutar la consulta
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devolver el resultado como un array asociativo
    }

    // Método para crear un nuevo comando en la base de datos
    public function createCommand($command, $description, $ayuda, $imagen, $ejemplo) {
        $query = "INSERT INTO linux_commands (command, description, ayuda, imagen, ejemplo) VALUES (:command, :description, :ayuda, :imagen, :ejemplo)"; // Consulta SQL para insertar un nuevo comando
        $stmt = $this->db->prepare($query); // Preparar la consulta
        $stmt->bindParam(":command", $command, PDO::PARAM_STR); // Enlazar los parámetros con los valores proporcionados
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":ayuda", $ayuda, PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $imagen, PDO::PARAM_STR);
        $stmt->bindParam(":ejemplo", $ejemplo, PDO::PARAM_STR);
        return $stmt->execute(); // Ejecutar la consulta y devolver true si tiene éxito, o false si falla
    }

    // Método para actualizar un comando existente en la base de datos
    public function updateCommand($id, $command, $description, $ayuda, $imagen, $ejemplo) {
        $query = "UPDATE linux_commands SET command = :command, description = :description, ayuda = :ayuda, imagen = :imagen, ejemplo = :ejemplo WHERE id = :id"; // Consulta SQL para actualizar un comando
        $stmt = $this->db->prepare($query); // Preparar la consulta
        $stmt->bindParam(":id", $id, PDO::PARAM_INT); // Enlazar los parámetros con los valores proporcionados
        $stmt->bindParam(":command", $command, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":ayuda", $ayuda, PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $imagen, PDO::PARAM_STR);
        $stmt->bindParam(":ejemplo", $ejemplo, PDO::PARAM_STR);
        return $stmt->execute(); // Ejecutar la consulta y devolver true si tiene éxito, o false si falla
    }

    // Método para eliminar un comando de la base de datos por su ID
    public function deleteCommand($id) {
        $query = "DELETE FROM linux_commands WHERE id = :id"; // Consulta SQL para eliminar un comando por su ID
        $stmt = $this->db->prepare($query); // Preparar la consulta
        $stmt->bindParam(":id", $id, PDO::PARAM_INT); // Enlazar el parámetro :id con el valor proporcionado
        return $stmt->execute(); // Ejecutar la consulta y devolver true si tiene éxito, o false si falla
    }
}
?>
