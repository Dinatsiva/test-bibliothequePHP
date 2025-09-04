<?php
class Livre {
    private $conn;
    private $table = "livre";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ajouter un livre
    public function ajouter($titre, $id_auteur, $annee_publication, $genre, $langue, $isbn, $quantite) {
        $sql = "INSERT INTO $this->table (titre, id_auteur, annee_publication, genre, langue, isbn, quantite)
                VALUES (:titre, :id_auteur, :annee_publication, :genre, :langue, :isbn, :quantite)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":titre", $titre);
        $stmt->bindParam(":id_auteur", $id_auteur);
        $stmt->bindParam(":annee_publication", $annee_publication);
        $stmt->bindParam(":genre", $genre);
        $stmt->bindParam(":langue", $langue);
        $stmt->bindParam(":isbn", $isbn);
        $stmt->bindParam(":quantite", $quantite);
        return $stmt->execute();
    }

    // Modifier un livre
    public function modifier($id_livre, $titre, $id_auteur, $annee_publication, $genre, $langue, $isbn, $quantite) {
        $sql = "UPDATE $this->table 
                SET titre = :titre, id_auteur = :id_auteur, annee_publication = :annee_publication,
                    genre = :genre, langue = :langue, isbn = :isbn, quantite = :quantite
                WHERE id_livre = :id_livre";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_livre", $id_livre);
        $stmt->bindParam(":titre", $titre);
        $stmt->bindParam(":id_auteur", $id_auteur);
        $stmt->bindParam(":annee_publication", $annee_publication);
        $stmt->bindParam(":genre", $genre);
        $stmt->bindParam(":langue", $langue);
        $stmt->bindParam(":isbn", $isbn);
        $stmt->bindParam(":quantite", $quantite);
        return $stmt->execute();
    }

    // Supprimer un livre
    public function supprimer($id_livre) {
        $sql = "DELETE FROM $this->table WHERE id_livre = :id_livre";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_livre", $id_livre);
        return $stmt->execute();
    }

    // Lister les livres avec pagination
    public function lister($limit = 10, $offset = 0) {
        $sql = "SELECT l.*, a.nom AS auteur_nom, a.prenom AS auteur_prenom 
                FROM $this->table l
                LEFT JOIN auteur a ON l.id_auteur = a.id_auteur
                ORDER BY l.titre ASC
                LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Recherche avec pagination
    public function rechercher($mot_cle, $limit = 10, $offset = 0) {
        $sql = "SELECT l.*, a.nom AS auteur_nom, a.prenom AS auteur_prenom
                FROM livre l
                LEFT JOIN auteur a ON l.id_auteur = a.id_auteur
                WHERE l.titre LIKE :mot_cle
                   OR l.id_livre = :mot_cle_exact
                   OR l.annee_publication LIKE :mot_cle
                   OR a.nom LIKE :mot_cle
                   OR a.prenom LIKE :mot_cle
                ORDER BY l.titre ASC
                LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":mot_cle", "%$mot_cle%");
        $stmt->bindValue(":mot_cle_exact", $mot_cle);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Compter tous les livres (pour pagination)
    public function countTotal() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    // Compter les résultats de recherche (pour pagination)
    public function countRecherche($mot_cle) {
        $sql = "SELECT COUNT(*) 
                FROM livre l
                LEFT JOIN auteur a ON l.id_auteur = a.id_auteur
                WHERE l.titre LIKE :mot_cle
                   OR l.id_livre = :mot_cle_exact
                   OR l.annee_publication LIKE :mot_cle
                   OR a.nom LIKE :mot_cle
                   OR a.prenom LIKE :mot_cle";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":mot_cle", "%$mot_cle%");
        $stmt->bindValue(":mot_cle_exact", $mot_cle);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Obtenir un livre par ID
    public function getById($id_livre) {
        $sql = "SELECT * FROM $this->table WHERE id_livre = :id_livre LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_livre", $id_livre);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
