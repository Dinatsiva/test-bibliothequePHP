<?php
class Database {
    private $host = "127.0.0.1";
    private $db_name = "bibliotheque";
    private $username = "root";   // ton user MySQL
    private $password = "";       // ton mot de passe MySQL
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
            exit; // arrêt si connexion impossible
        }

        return $this->conn;
    }
}
?>
