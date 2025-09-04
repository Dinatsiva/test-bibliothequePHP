<?php
require_once __DIR__ . "/../config/db.php";

class Livre {
    private $conn;
    private $table = "livre";

    public $id_livre;
    public $titre;
    public $annee_publication;
    public $genre;
    public $langue;
    public $isbn;
    public $quantite;
    public $id_auteur;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Récupérer tous les livres
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY titre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ajouter un livre
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 (titre, annee_publication, genre, langue, isbn, quantite, id_auteur)
                  VALUES (:titre, :annee_publication, :genre, :langue, :isbn, :quantite, :id_auteur)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":annee_publication", $this->annee_publication);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":langue", $this->langue);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":quantite", $this->quantite);
        $stmt->bindParam(":id_auteur", $this->id_auteur);

        return $stmt->execute();
    }

    // Modifier un livre
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET titre=:titre, annee_publication=:annee_publication, genre=:genre, langue=:langue, isbn=:isbn, quantite=:quantite, id_auteur=:id_auteur
                  WHERE id_livre=:id_livre";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":annee_publication", $this->annee_publication);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":langue", $this->langue);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":quantite", $this->quantite);
        $stmt->bindParam(":id_auteur", $this->id_auteur);
        $stmt->bindParam(":id_livre", $this->id_livre);

        return $stmt->execute();
    }

    // Supprimer un livre
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id_livre = :id_livre";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_livre", $this->id_livre);
        return $stmt->execute();
    }
}
