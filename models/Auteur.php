<?php
class Auteur {
    private $conn;
    private $table = "auteur";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lister tous les auteurs
    public function lister() {
        $sql = "SELECT * FROM $this->table ORDER BY nom ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // Obtenir un auteur par ID
    public function getById($id_auteur) {
        $sql = "SELECT * FROM $this->table WHERE id_auteur = :id_auteur LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_auteur", $id_auteur);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un auteur
    public function ajouter($nom, $prenom, $nationalite, $date_naissance, $date_deces=null) {
        $sql = "INSERT INTO $this->table (nom, prenom, nationalite, date_naissance, date_deces) 
                VALUES (:nom, :prenom, :nationalite, :date_naissance, :date_deces)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":nationalite", $nationalite);
        $stmt->bindParam(":date_naissance", $date_naissance);
        $stmt->bindParam(":date_deces", $date_deces);
        return $stmt->execute();
    }

    // Modifier un auteur
    public function modifier($id_auteur, $nom, $prenom, $nationalite, $date_naissance, $date_deces=null) {
        $sql = "UPDATE $this->table 
                SET nom = :nom, prenom = :prenom, nationalite = :nationalite, 
                    date_naissance = :date_naissance, date_deces = :date_deces
                WHERE id_auteur = :id_auteur";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":nationalite", $nationalite);
        $stmt->bindParam(":date_naissance", $date_naissance);
        $stmt->bindParam(":date_deces", $date_deces);
        $stmt->bindParam(":id_auteur", $id_auteur);
        return $stmt->execute();
    }

    // Supprimer un auteur
    public function supprimer($id_auteur) {
        $sql = "DELETE FROM $this->table WHERE id_auteur = :id_auteur";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_auteur", $id_auteur);
        return $stmt->execute();
    }
    public function rechercher($mot_cle) {
    $sql = "SELECT * FROM auteur 
            WHERE nom LIKE :mot_cle
               OR prenom LIKE :mot_cle
               OR nationalite LIKE :mot_cle
               OR id_auteur = :mot_cle_exact
            ORDER BY nom ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":mot_cle", "%$mot_cle%");
    $stmt->bindValue(":mot_cle_exact", $mot_cle);
    $stmt->execute();
    return $stmt;
}

}
?>
