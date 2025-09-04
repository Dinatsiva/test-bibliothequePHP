<?php
require_once "../../includes/auth.php";
require_once "../../controllers/exemplaireController.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste des exemplaires</title>
</head>
<body>
<h2>Exemplaires</h2>
<?php if(isset($_GET['success'])) echo "<p style='color:green;'>Action réussie!</p>"; ?>

<a href="ajouter.php">Ajouter un exemplaire</a>
<form method="GET" action="index.php">
    <input type="hidden" name="action" value="recherche">
    <input type="text" name="q" placeholder="Rechercher...">
    <button type="submit">Rechercher</button>
</form>

<table border="1">
<tr>
    <th>ID</th>
    <th>Livre</th>
    <th>État</th>
    <th>Disponible</th>
    <th>Rayon</th>
    <th>Actions</th>
</tr>
<?php foreach($exemplaires as $ex): ?>
<tr>
    <td><?= $ex['id_exemplaire'] ?></td>
    <td><?= $ex['livre_titre'] ?></td>
    <td><?= $ex['etat'] ?></td>
    <td><?= $ex['disponible'] ?></td>
    <td><?= $ex['rayon_nom'] ?></td>
    <td>
        <a href="modifier.php?id=<?= $ex['id_exemplaire'] ?>">Modifier</a> |
        <a href="../../controllers/exemplaireController.php?action=supprimer&id=<?= $ex['id_exemplaire'] ?>">Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<a href="../../public/dashboard.php">Retour au dashboard</a>
</body>
</html>
