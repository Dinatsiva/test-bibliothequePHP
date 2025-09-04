<?php
class Utilisateur {
    private $conn;
    private $table = "utilisateur";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Vérifier login
    public function login($email, $mot_de_passe) {
        $sql = "SELECT * FROM $this->table WHERE email = :email AND statut = 'actif' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie si l'utilisateur existe et que le mot de passe correspond
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            return $user;
        }
        return false;
    }

    // Ajouter un utilisateur (hash automatique)
    public function ajouter($nom, $prenom, $email, $mot_de_passe, $role='membre') {
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table (nom, prenom, email, mot_de_passe, role, statut)
                VALUES (:nom, :prenom, :email, :mot_de_passe, :role, 'actif')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":mot_de_passe", $hash);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }

    // Lister tous les utilisateurs
    public function lister() {
        $sql = "SELECT * FROM $this->table ORDER BY nom ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifier($id_utilisateur, $nom, $prenom, $email, $role, $statut) {
        $sql = "UPDATE $this->table SET nom = :nom, prenom = :prenom, email = :email, role = :role, statut = :statut
                WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":statut", $statut);
        $stmt->bindParam(":id_utilisateur", $id_utilisateur);
        return $stmt->execute();
    }

    public function getById($id_utilisateur) {
        $sql = "SELECT * FROM $this->table WHERE id_utilisateur = :id_utilisateur LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_utilisateur", $id_utilisateur);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function supprimer($id_utilisateur) {
        $sql = "DELETE FROM $this->table WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_utilisateur", $id_utilisateur);
        return $stmt->execute();
    }

    public function rechercher($q) {
        $sql = "SELECT * FROM $this->table WHERE nom LIKE :q OR prenom LIKE :q OR email LIKE :q ORDER BY nom ASC";
        $stmt = $this->conn->prepare($sql);
        $q_param = "%$q%";
        $stmt->bindParam(":q", $q_param);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
