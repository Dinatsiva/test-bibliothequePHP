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

// ACTIONS CRUD
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'ajouter') {
        $livre->ajouter($_POST['titre'], $_POST['id_auteur'], $_POST['annee_publication'],
                        $_POST['genre'], $_POST['langue'], $_POST['isbn'], $_POST['quantite']);
        header("Location: ../views/livres/index.php?success=1");
        exit;
    }
    if ($_POST['action'] === 'modifier') {
        $livre->modifier($_POST['id_livre'], $_POST['titre'], $_POST['id_auteur'], $_POST['annee_publication'],
                        $_POST['genre'], $_POST['langue'], $_POST['isbn'], $_POST['quantite']);
        header("Location: ../views/livres/index.php?success=2");
        exit;
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'supprimer' && isset($_GET['id'])) {
        $livre->supprimer($_GET['id']);
        header("Location: ../views/livres/index.php?success=3");
        exit;
    }
}

// PAGINATION ET RECHERCHE
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

if (isset($_GET['action']) && $_GET['action'] === 'recherche' && isset($_GET['q'])) {
    $q = $_GET['q'];
    $livres = $livre->rechercher($q, $limit, $offset);
    $total = $livre->countRecherche($q);
} else {
    $livres = $livre->lister($limit, $offset);
    $total = $livre->countTotal();
}

$totalPages = ceil($total / $limit);
?>
