<?php include("../includes/header.php"); ?>
<div class="container mt-4">
    <h2>Liste des livres</h2>
<?php if($_SESSION['user_role'] === 'admin'): ?>
    <div class="mb-3">
        <a href="../exports/export_livres_csv.php" class="btn btn-success">Exporter CSV</a>
        <a href="../exports/export_livres_pdf.php" class="btn btn-primary">Exporter PDF</a>
    </div>
<?php endif; ?>


    <a href="ajouter.php" class="btn btn-success mb-3">Ajouter un livre</a>

    <form method="GET" action="index.php" class="mb-3">
        <input type="hidden" name="action" value="recherche">
        <input type="text" name="q" placeholder="Rechercher par titre, auteur, id..."
            value="<?= isset($q) ? htmlspecialchars($q) : '' ?>">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
                <th>Genre</th>
                <th>Langue</th>
                <th>Quantité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $livres->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['id_livre'] ?></td>
                    <td><?= htmlspecialchars($row['titre']) ?></td>
                    <td><?= htmlspecialchars($row['auteur_nom'] . ' ' . $row['auteur_prenom']) ?></td>
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

    <!-- PAGINATION -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                        <a class="page-link"
                            href="?<?= isset($q) ? "action=recherche&q=$q&" : '' ?>page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
<?php include("../includes/footer.php"); ?>