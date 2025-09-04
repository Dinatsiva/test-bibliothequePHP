<?php
require_once "../includes/auth.php";  // Protection de la page

require_once "../config/db.php";
require_once "../models/Utilisateur.php";
require_once "../models/Livre.php";

// Connexion DB
$database = new Database();
$db = $database->getConnection();

// Objets modèles
$utilisateurModel = new Utilisateur($db);
$livreModel = new Livre($db);

// Statistiques
$totalUsers = $utilisateurModel->lister()->rowCount();
$totalLivres = $livreModel->lister()->rowCount();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .stats { display:flex; gap:20px; margin-bottom:20px; }
        .card { padding:20px; border:1px solid #ccc; border-radius:10px; flex:1; background:#f4f4f4; text-align:center; }
        ul { list-style:none; padding-left:0; }
        li { margin-bottom:10px; }
        a { text-decoration:none; color:#333; font-weight:bold; }
    </style>
</head>
<body>
<div class="container">
    <h2>Bienvenue <?= $_SESSION['user_prenom'] ?> <?= $_SESSION['user_nom'] ?></h2>
    <p>Rôle : <?= $_SESSION['user_role'] ?></p>

    <a href="../controllers/utilisateurController.php?action=logout">Se déconnecter</a>

    <?php if($_SESSION['user_role'] === 'admin'): ?>
        <div class="stats">
            <div class="card">
                <h3>Utilisateurs</h3>
                <p><?= $totalUsers ?></p>
                <a href="../views/utilisateurs/index.php">Gérer</a>
            </div>
            <div class="card">
                <h3>Livres</h3>
                <p><?= $totalLivres ?></p>
                <a href="../views/livres/index.php">Gérer</a>
            </div>
        </div>
    <?php else: ?>
        <div class="stats">
            <div class="card">
                <h3>Livres disponibles</h3>
                <a href="../views/livres/index.php">Voir les livres</a>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
