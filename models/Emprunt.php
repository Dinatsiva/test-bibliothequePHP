<?php
class Emprunt {
    private $conn;
    private $table = "emprunt";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajouter($id_utilisateur, $id_exemplaire, $date_emprunt, $date_retour_prevue) {
        $sql = "INSERT INTO $this->table (id_utilisateur, id_livre, date_emprunt, date_retour_prevue)
                SELECT :id_utilisateur, id_livre, :date_emprunt, :date_retour_prevue FROM exemplaire WHERE id_exemplaire = :id_exemplaire";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_utilisateur", $id_utilisateur);
        $stmt->bindParam(":date_emprunt", $date_emprunt);
        $stmt->bindParam(":date_retour_prevue", $date_retour_prevue);
        $stmt->bindParam(":id_exemplaire", $id_exemplaire);
        return $stmt->execute();
    }

    public function retour($id_emprunt, $date_retour_effective, $statut) {
        $sql = "UPDATE $this->table SET date_retour_effective = :date_retour, statut = :statut WHERE id_emprunt = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":date_retour", $date_retour_effective);
        $stmt->bindParam(":statut", $statut);
        $stmt->bindParam(":id", $id_emprunt);
        return $stmt->execute();
    }

    public function getById($id_emprunt) {
        $sql = "SELECT e.*, ex.id_exemplaire, ex.etat AS etat_exemplaire, ex.id_rayon 
                FROM $this->table e 
                JOIN exemplaire ex ON e.id_livre = ex.id_livre
                WHERE e.id_emprunt = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id_emprunt);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lister() {
        $sql = "SELECT e.*, u.nom, u.prenom, ex.id_exemplaire, ex.etat AS etat_exemplaire
                FROM $this->table e
                JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
                JOIN exemplaire ex ON e.id_livre = ex.id_livre
                ORDER BY e.date_emprunt DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function listerParUtilisateur($id_utilisateur) {
        $sql = "SELECT e.*, ex.id_exemplaire, ex.etat AS etat_exemplaire 
                FROM $this->table e
                JOIN exemplaire ex ON e.id_livre = ex.id_livre
                WHERE e.id_utilisateur = :id
                ORDER BY e.date_emprunt DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id_utilisateur);
        $stmt->execute();
        return $stmt;
    }
    public function rechercher($mot_cle) {
    $sql = "SELECT e.*, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, l.titre AS livre_titre
            FROM emprunt e
            LEFT JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
            LEFT JOIN livre l ON e.id_livre = l.id_livre
            WHERE e.id_emprunt = :mot_cle_exact
               OR u.nom LIKE :mot_cle
               OR u.prenom LIKE :mot_cle
               OR l.titre LIKE :mot_cle
            ORDER BY e.date_emprunt DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":mot_cle", "%$mot_cle%");
    $stmt->bindValue(":mot_cle_exact", $mot_cle);
    $stmt->execute();
    return $stmt;
}

}
?>
