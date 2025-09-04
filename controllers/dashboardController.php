<?php
session_start();
require_once __DIR__ . "/../config/db.php";

$database = new Database();
$db = $database->getConnection();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Récupérer le rôle
$role = $_SESSION['user_role'];

// Statistiques
$stats = [];

// Admin : voir tous les emprunts et retards
if($role === 'admin') {
    // Total utilisateurs
    $stmt = $db->query("SELECT COUNT(*) AS total_utilisateurs FROM utilisateur");
    $stats['total_utilisateurs'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_utilisateurs'];

    // Total livres
    $stmt = $db->query("SELECT COUNT(*) AS total_livres FROM livre");
    $stats['total_livres'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_livres'];

    // Emprunts en cours
    $stmt = $db->query("SELECT COUNT(*) AS emprunts_en_cours FROM emprunt WHERE statut='en cours'");
    $stats['emprunts_en_cours'] = $stmt->fetch(PDO::FETCH_ASSOC)['emprunts_en_cours'];

    // Emprunts en retard
    $stmt = $db->query("SELECT COUNT(*) AS emprunts_en_retard FROM emprunt WHERE statut='en retard'");
    $stats['emprunts_en_retard'] = $stmt->fetch(PDO::FETCH_ASSOC)['emprunts_en_retard'];

    // Livres disponibles (exemplaires)
    $stmt = $db->query("SELECT COUNT(*) AS livres_disponibles FROM exemplaire WHERE disponible='oui'");
    $stats['livres_disponibles'] = $stmt->fetch(PDO::FETCH_ASSOC)['livres_disponibles'];

} else { // Membre : voir ses propres emprunts
    $user_id = $_SESSION['user_id'];

    // Ses emprunts en cours
    $stmt = $db->prepare("SELECT COUNT(*) AS emprunts_en_cours FROM emprunt WHERE id_utilisateur = :id AND statut='en cours'");
    $stmt->bindParam(":id", $user_id);
    $stmt->execute();
    $stats['emprunts_en_cours'] = $stmt->fetch(PDO::FETCH_ASSOC)['emprunts_en_cours'];

    // Ses emprunts en retard
    $stmt = $db->prepare("SELECT COUNT(*) AS emprunts_en_retard FROM emprunt WHERE id_utilisateur = :id AND statut='en retard'");
    $stmt->bindParam(":id", $user_id);
    $stmt->execute();
    $stats['emprunts_en_retard'] = $stmt->fetch(PDO::FETCH_ASSOC)['emprunts_en_retard'];
}
?>
