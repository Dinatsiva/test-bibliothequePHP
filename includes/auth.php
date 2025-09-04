<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirige vers la page de login si non connecté
    header("Location: ../views/utilisateurs/login.php");
    exit;
}
?>
