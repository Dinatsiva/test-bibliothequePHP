<?php include("../includes/header.php"); ?>
<div class="container mt-4">
    <h2>Liste des livres</h2>
    <a href="ajouter.php" class="btn btn-success mb-3">Ajouter un livre</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Titre</th><th>Auteur</th><th>Année</th><th>Genre</th><th>Langue</th><th>Quantité</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $livres->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['id_livre'] ?></td>
                    <td><?= htmlspecialchars($row['titre']) ?></td>
                    <td><?= htmlspecialchars($row['auteur_nom'].' '.$row['auteur_prenom']) ?></td>
                    <td><?= $row['annee_publication'] ?></td>
                    <td><?= $row['genre'] ?></td>
                    <td><?= $row['langue'] ?></td>
                    <td><?= $row['quantite'] ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $row['id_livre'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="../../controllers/livreController.php?action=supprimer&id=<?= $row['id_livre'] ?>" 
                           onclick="return confirm('Supprimer ce livre ?');" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include("../includes/footer.php"); ?>
