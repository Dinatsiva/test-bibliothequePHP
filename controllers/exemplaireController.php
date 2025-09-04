<?php
session_start();
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Exemplaire.php";
require_once __DIR__ . "/../models/Rayon.php";

$database = new Database();
$db = $database->getConnection();

$exemplaire = new Exemplaire($db);
$rayon = new Rayon($db);

// Ajouter un exemplaire
if(isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $exemplaire->ajouter($_POST['id_livre'], $_POST['etat'], $_POST['id_rayon']);
    header("Location: ../views/exemplaires/index.php?success=1");
    exit;
}

// Modifier un exemplaire
if(isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $exemplaire->modifier($_POST['id_exemplaire'], $_POST['etat'], $_POST['disponible'], $_POST['id_rayon']);
    header("Location: ../views/exemplaires/index.php?success=1");
    exit;
}

// Supprimer un exemplaire
if(isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $exemplaire->supprimer($_GET['id']);
    header("Location: ../views/exemplaires/index.php?success=1");
    exit;
}

// Lister les exemplaires
$exemplaires = $exemplaire->lister()->fetchAll(PDO::FETCH_ASSOC);
$rayons = $rayon->lister()->fetchAll(PDO::FETCH_ASSOC);
?>
