<?php
session_start();
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Utilisateur.php";

// Connexion à la BDD
$database = new Database();
$db = $database->getConnection();
$utilisateur = new Utilisateur($db);

// LOGIN
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    $user = $utilisateur->login($email, $mot_de_passe);

    if ($user) {
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];
        $_SESSION['user_role'] = $user['role'];

        // après login réussi
        header("Location: dashboard.php"); // relatif à public/
        exit;

    } else {
        header("Location: /login.php?error=1");
        exit;
    }
}

// LOGOUT
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: ../public/login.php");
    exit;
}

// SUPPRIMER utilisateur
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $utilisateur->supprimer($_GET['id']);
    header("Location: ../views/utilisateurs/index.php?success=1");
    exit;
}

// LISTER utilisateurs
$users = $utilisateur->lister();
?>