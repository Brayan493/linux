<?php
class LinuxCommandModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCommands() {
        $query = "SELECT * FROM linux_commands";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommandById($id) {
        $query = "SELECT * FROM linux_commands WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCommand($command, $description, $ayuda, $imagen, $ejemplo) {
        $query = "INSERT INTO linux_commands (command, description, ayuda, imagen, ejemplo) VALUES (:command, :description, :ayuda, :imagen, :ejemplo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":command", $command, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":ayuda", $ayuda, PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $imagen, PDO::PARAM_STR);
        $stmt->bindParam(":ejemplo", $ejemplo, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateCommand($id, $command, $description, $ayuda, $imagen, $ejemplo) {
        $query = "UPDATE linux_commands SET command = :command, description = :description, ayuda = :ayuda, imagen = :imagen, ejemplo = :ejemplo WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":command", $command, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":ayuda", $ayuda, PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $imagen, PDO::PARAM_STR);
        $stmt->bindParam(":ejemplo", $ejemplo, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteCommand($id) {
        $query = "DELETE FROM linux_commands WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
