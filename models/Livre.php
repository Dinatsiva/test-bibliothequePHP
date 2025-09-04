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

    // Lister tous les livres
    public function lister() {
        $sql = "SELECT l.*, a.nom AS auteur_nom, a.prenom AS auteur_prenom 
                FROM $this->table l
                LEFT JOIN auteur a ON l.id_auteur = a.id_auteur
                ORDER BY l.titre ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
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
