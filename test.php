<?php
$host = "127.0.0.1";
$db_name = "bibliotheque";
$username = "root";   // ton utilisateur MySQL
$password = "";       // ton mot de passe MySQL

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données !";
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
