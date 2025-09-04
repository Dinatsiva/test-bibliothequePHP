<?php include __DIR__ . "/../../includes/header.php"; ?>
<h2>Liste des livres</h2>
<a href="index.php?action=ajouter_livre" class="btn btn-primary">Ajouter un livre</a>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Titre</th><th>Auteur</th><th>Année</th><th>Quantité</th><th>Actions</th>
    </tr>
    <?php foreach($livres as $livre): ?>
    <tr>
        <td><?= $livre['id_livre']; ?></td>
        <td><?= $livre['titre']; ?></td>
        <td><?= $livre['id_auteur']; ?></td>
        <td><?= $livre['annee_publication']; ?></td>
        <td><?= $livre['quantite']; ?></td>
        <td>
            <a href="index.php?action=modifier_livre&id=<?= $livre['id_livre']; ?>">Modifier</a> | 
            <a href="index.php?action=supprimer_livre&id=<?= $livre['id_livre']; ?>">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include __DIR__ . "/../../includes/footer.php"; ?>
