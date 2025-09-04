<?php
class Rayon {
    private $conn;
    private $table = "rayon";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lister tous les rayons
    public function lister() {
        $sql = "SELECT * FROM $this->table ORDER BY nom ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // Ajouter un rayon
    public function ajouter($nom, $description, $emplacement) {
        $sql = "INSERT INTO $this->table (nom, description, emplacement) 
                VALUES (:nom, :description, :emplacement)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":emplacement", $emplacement);
        return $stmt->execute();
    }

    // Obtenir un rayon par ID
    public function getById($id_rayon) {
        $sql = "SELECT * FROM $this->table WHERE id_rayon = :id_rayon LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_rayon", $id_rayon);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Modifier un rayon
    public function modifier($id_rayon, $nom, $description, $emplacement) {
        $sql = "UPDATE $this->table SET nom = :nom, description = :description, emplacement = :emplacement
                WHERE id_rayon = :id_rayon";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":emplacement", $emplacement);
        $stmt->bindParam(":id_rayon", $id_rayon);
        return $stmt->execute();
    }

    // Supprimer un rayon
    public function supprimer($id_rayon) {
        $sql = "DELETE FROM $this->table WHERE id_rayon = :id_rayon";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_rayon", $id_rayon);
        return $stmt->execute();
    }
}
?>
