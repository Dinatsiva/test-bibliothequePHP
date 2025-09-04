<?php
class Utilisateur {
    private $conn;
    private $table = "utilisateur";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $hash = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("
            INSERT INTO {$this->table} (nom, prenom, email, mot_de_passe, role) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :role)
        ");
        return $stmt->execute([
            ':nom' => $data['nom'],
            ':prenom' => $data['prenom'],
            ':email' => $data['email'],
            ':mot_de_passe' => $hash,
            ':role' => $data['role'] ?? 'membre'
        ]);
    }
}
