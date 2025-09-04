<?php
class Exemplaire {
    private $conn;
    private $table = "exemplaire";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lister les exemplaires (option: par livre ou rayon)
    public function lister($id_livre = null, $id_rayon = null) {
        $sql = "SELECT ex.*, l.titre AS livre_titre, r.nom AS rayon_nom 
                FROM $this->table ex
                JOIN livre l ON ex.id_livre = l.id_livre
                LEFT JOIN rayon r ON ex.id_rayon = r.id_rayon
                WHERE 1";

        if($id_livre) $sql .= " AND ex.id_livre = $id_livre";
        if($id_rayon) $sql .= " AND ex.id_rayon = $id_rayon";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // Ajouter un exemplaire
    public function ajouter($id_livre, $etat='bon', $id_rayon=null) {
        $sql = "INSERT INTO $this->table (id_livre, etat, id_rayon) VALUES (:id_livre, :etat, :id_rayon)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_livre", $id_livre);
        $stmt->bindParam(":etat", $etat);
        $stmt->bindParam(":id_rayon", $id_rayon);
        return $stmt->execute();
    }

    // Modifier un exemplaire
    public function modifier($id_exemplaire, $etat, $disponible, $id_rayon) {
        $sql = "UPDATE $this->table SET etat = :etat, disponible = :disponible, id_rayon = :id_rayon
                WHERE id_exemplaire = :id_exemplaire";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":etat", $etat);
        $stmt->bindParam(":disponible", $disponible);
        $stmt->bindParam(":id_rayon", $id_rayon);
        $stmt->bindParam(":id_exemplaire", $id_exemplaire);
        return $stmt->execute();
    }

    // Supprimer un exemplaire
    public function supprimer($id_exemplaire) {
        $sql = "DELETE FROM $this->table WHERE id_exemplaire = :id_exemplaire";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_exemplaire", $id_exemplaire);
        return $stmt->execute();
    }

    // Obtenir un exemplaire par ID
    public function getById($id_exemplaire) {
        $sql = "SELECT * FROM $this->table WHERE id_exemplaire = :id_exemplaire LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_exemplaire", $id_exemplaire);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rechercher($mot_cle) {
    $sql = "SELECT ex.*, l.titre AS livre_titre, r.nom AS rayon_nom
            FROM exemplaire ex
            LEFT JOIN livre l ON ex.id_livre = l.id_livre
            LEFT JOIN rayon r ON ex.id_rayon = r.id_rayon
            WHERE ex.id_exemplaire = :mot_cle_exact
               OR l.titre LIKE :mot_cle
               OR r.nom LIKE :mot_cle
            ORDER BY ex.id_exemplaire ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":mot_cle", "%$mot_cle%");
    $stmt->bindValue(":mot_cle_exact", $mot_cle);
    $stmt->execute();
    return $stmt;
}

}
?>
