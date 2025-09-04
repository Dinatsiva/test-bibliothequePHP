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
$recherche_resultats = [];

if(isset($_GET['q']) && !empty($_GET['q']) && isset($_GET['module'])) {
    $q = $_GET['q'];
    $module = $_GET['module'];

    switch($module) {
        case 'livres':
            require_once __DIR__ . "/../models/Livre.php";
            $livre = new Livre($db);
            $recherche_resultats = $livre->rechercher($q)->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 'auteurs':
            require_once __DIR__ . "/../models/Auteur.php";
            $auteur = new Auteur($db);
            $recherche_resultats = $auteur->rechercher($q)->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 'utilisateurs':
            if($_SESSION['user_role'] === 'admin'){
                require_once __DIR__ . "/../models/Utilisateur.php";
                $utilisateur = new Utilisateur($db);
                $recherche_resultats = $utilisateur->rechercher($q)->fetchAll(PDO::FETCH_ASSOC);
            }
            break;
        case 'emprunts':
            require_once __DIR__ . "/../models/Emprunt.php";
            $emprunt = new Emprunt($db);
            $recherche_resultats = $emprunt->rechercher($q)->fetchAll(PDO::FETCH_ASSOC);
            break;
        case 'exemplaires':
            require_once __DIR__ . "/../models/Exemplaire.php";
            $exemplaire = new Exemplaire($db);
            $recherche_resultats = $exemplaire->rechercher($q)->fetchAll(PDO::FETCH_ASSOC);
            break;
    }
}

?>
