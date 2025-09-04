<?php
session_start();
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Emprunt.php";

$database = new Database();
$db = $database->getConnection();
$emprunt = new Emprunt($db);

// Vérifier si connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/index.php");
    exit;
}

// Emprunter un livre
if(isset($_POST['action']) && $_POST['action'] === 'emprunter') {
    $id_utilisateur = $_SESSION['user_id'];
    $id_exemplaire = $_POST['id_exemplaire'];
    $date_retour_prevue = $_POST['date_retour_prevue'];

    $success = $emprunt->emprunter($id_utilisateur, $id_exemplaire, $date_retour_prevue);
    header("Location: ../views/emprunts/index.php?success=" . ($success ? 1 : 0));
    exit;
}

// Retourner un livre
if(isset($_GET['action']) && $_GET['action']==='retourner' && isset($_GET['id'])) {
    $emprunt->retourner($_GET['id']);
    header("Location: ../views/emprunts/index.php");
    exit;
}

// Lister emprunts
$emprunts = ($_SESSION['user_role']==='admin') ? $emprunt->lister() : $emprunt->lister($_SESSION['user_id']);
?>
