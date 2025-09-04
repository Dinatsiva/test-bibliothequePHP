<?php
session_start();
require_once "../../controllers/empruntController.php";
?>
<h2>Liste des emprunts</h2>

<?php if(isset($_GET['success'])): ?>
    <p style="color:green;"><?= $_GET['success']==1 ? "Opération réussie" : "Échec de l'opération" ?></p>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>Utilisateur</th>
        <th>Livre</th>
        <th>Date emprunt</th>
        <th>Date retour prévue</th>
        <th>Date retour effective</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $emprunts->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= $row['nom'] ?> <?= $row['prenom'] ?></td>
            <td><?= $row['titre'] ?></td>
            <td><?= $row['date_emprunt'] ?></td>
            <td><?= $row['date_retour_prevue'] ?></td>
            <td><?= $row['date_retour_effective'] ?? '-' ?></td>
            <td><?= $row['statut'] ?></td>
            <td>
                <?php if($row['statut'] === 'en cours'): ?>
                    <a href="../../controllers/empruntController.php?action=retourner&id=<?= $row['id_emprunt'] ?>">Retourner</a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
