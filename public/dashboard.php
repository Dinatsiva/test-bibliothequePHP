<?php
require_once "../controllers/dashboardController.php";
?>
<?php if($_SESSION['user_role'] === 'admin'): ?>
    <li><a href="../views/emprunts/index.php">Gérer les emprunts</a></li>
    <li><a href="../views/emprunts/ajouter.php">Nouvel emprunt</a></li>
<?php else: ?>
    <li><a href="../views/emprunts/index.php">Mes emprunts</a></li>
    <li><a href="../views/emprunts/ajouter.php">Emprunter un livre</a></li>
<?php endif; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Bienvenue <?= $_SESSION['user_prenom'] ?> <?= $_SESSION['user_nom'] ?></h2>
    <p>Rôle : <?= $_SESSION['user_role'] ?></p>
    <a href="../controllers/utilisateurController.php?action=logout">Se déconnecter</a>

    <h3>Statistiques</h3>
    <ul>
        <?php if($_SESSION['user_role'] === 'admin'): ?>
            <li>Total utilisateurs : <?= $stats['total_utilisateurs'] ?></li>
            <li>Total livres : <?= $stats['total_livres'] ?></li>
            <li>Emprunts en cours : <?= $stats['emprunts_en_cours'] ?></li>
            <li>Emprunts en retard : <?= $stats['emprunts_en_retard'] ?></li>
            <li>Livres disponibles : <?= $stats['livres_disponibles'] ?></li>
        <?php else: ?>
            <li>Vos emprunts en cours : <?= $stats['emprunts_en_cours'] ?></li>
            <li>Vos emprunts en retard : <?= $stats['emprunts_en_retard'] ?></li>
        <?php endif; ?>
    </ul>

    <?php if($_SESSION['user_role'] === 'admin'): ?>
        <h3>Admin Menu</h3>
        <ul>
            <li><a href="../views/utilisateurs/index.php">Gérer les utilisateurs</a></li>
            <li><a href="../views/livres/index.php">Gérer les livres</a></li>
            <li><a href="../views/exemplaires/index.php">Gérer les exemplaires</a></li>
            <li><a href="../views/rayons/index.php">Gérer les rayons</a></li>
            <li><a href="../views/emprunts/index.php">Gérer les emprunts</a></li>
        </ul>
    <?php else: ?>
        <h3>Membre Menu</h3>
        <ul>
            <li><a href="../views/livres/index.php">Voir les livres</a></li>
            <li><a href="../views/emprunts/index.php">Voir mes emprunts</a></li>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>
