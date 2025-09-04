<?php
session_start();
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Livre.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/index.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$livre = new Livre($db);

// ACTION: Ajouter
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $livre->ajouter(
        $_POST['titre'],
        $_POST['id_auteur'],
        $_POST['annee_publication'],
        $_POST['genre'],
        $_POST['langue'],
        $_POST['isbn'],
        $_POST['quantite']
    );
    header("Location: ../views/livres/index.php?success=1");
    exit;
}

// ACTION: Modifier
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $livre->modifier(
        $_POST['id_livre'],
        $_POST['titre'],
        $_POST['id_auteur'],
        $_POST['annee_publication'],
        $_POST['genre'],
        $_POST['langue'],
        $_POST['isbn'],
        $_POST['quantite']
    );
    header("Location: ../views/livres/index.php?success=2");
    exit;
}

// ACTION: Supprimer
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $livre->supprimer($_GET['id']);
    header("Location: ../views/livres/index.php?success=3");
    exit;
}

// ACTION: Lister
$livres = $livre->lister();
?>
