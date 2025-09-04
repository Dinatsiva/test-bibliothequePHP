<?php
require_once "../../includes/auth.php";
require_once "../../controllers/auteurController.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des Auteurs</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2>Auteurs</h2>
    <a href="ajouter.php" class="btn btn-success">Ajouter un auteur</a>
    <form method="GET" action="index.php">
    <input type="hidden" name="action" value="recherche">
    <input type="text" name="q" placeholder="Rechercher...">
    <button type="submit">Rechercher</button>
</form>


    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">Action effectuée avec succès !</div>
    <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Nationalité</th>
            <th>Date Naissance</th>
            <th>Date Décès</th>
            <th>Actions</th>
        </tr>
        <?php foreach($auteurs as $a): ?>
            <tr>
                <td><?= $a['id_auteur'] ?></td>
                <td><?= $a['nom'] ?></td>
                <td><?= $a['prenom'] ?></td>
                <td><?= $a['nationalite'] ?></td>
                <td><?= $a['date_naissance'] ?></td>
                <td><?= $a['date_deces'] ?></td>
                <td>
                    <a href="modifier.php?id=<?= $a['id_auteur'] ?>">Modifier</a> | 
                    <a href="../../controllers/auteurController.php?action=supprimer&id=<?= $a['id_auteur'] ?>" onclick="return confirm('Supprimer cet auteur ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
