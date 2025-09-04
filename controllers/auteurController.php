<?php
session_start();
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Auteur.php";

$database = new Database();
$db = $database->getConnection();
$auteur = new Auteur($db);

// Ajouter un auteur
if(isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $auteur->ajouter($_POST['nom'], $_POST['prenom'], $_POST['nationalite'], $_POST['date_naissance'], $_POST['date_deces']);
    header("Location: ../views/auteurs/index.php?success=1");
    exit;
}

// Modifier un auteur
if(isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $auteur->modifier($_POST['id_auteur'], $_POST['nom'], $_POST['prenom'], $_POST['nationalite'], $_POST['date_naissance'], $_POST['date_deces']);
    header("Location: ../views/auteurs/index.php?success=1");
    exit;
}

// Supprimer un auteur
if(isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $auteur->supprimer($_GET['id']);
    header("Location: ../views/auteurs/index.php?success=1");
    exit;
}
if(isset($_GET['action']) && $_GET['action'] === 'recherche' && isset($_GET['q'])) {
    $q = $_GET['q'];
    $resultats = $objet->rechercher($q)->fetchAll(PDO::FETCH_ASSOC);
} else {
    $resultats = $objet->lister()->fetchAll(PDO::FETCH_ASSOC);
}


// Lister les auteurs
$auteurs = $auteur->lister()->fetchAll(PDO::FETCH_ASSOC);
?>
