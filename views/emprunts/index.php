<?php
session_start();
require_once __DIR__ . "/../../includes/auth.php"; // Vérifie si connecté
require_once __DIR__ . "/../../controllers/empruntController.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Liste des emprunts</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .success {
            background: #d4edda;
            padding: 10px;
            margin-bottom: 15px;
            color: #155724;
            border-radius: 5px;
        }

        .error {
            background: #f8d7da;
            padding: 10px;
            margin-bottom: 15px;
            color: #721c24;
            border-radius: 5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #ccc;
        }

        th {
            background: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-return {
            background: #28a745;
            color: #fff;
        }

        .btn-disabled {
            background: #6c757d;
            color: #fff;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="GET" action="index.php">
            <input type="hidden" name="action" value="recherche">
            <input type="text" name="q" placeholder="Rechercher...">
            <button type="submit">Rechercher</button>
        </form>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <div class="mb-3">
                <a href="../exports/export_emprunts_csv.php" class="btn btn-success">Exporter CSV</a>
            </div>
        <?php endif; ?>


        <h2>Liste des emprunts</h2>
        <?php if ($_SESSION['user_role'] === 'admin'): ?>
            <div class="mb-3">
                <a href="../exports/export_emprunts_csv.php" class="btn btn-success">Exporter CSV</a>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">Action réussie !</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">Action impossible ! Exemplaire indisponible ou erreur.</div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID Emprunt</th>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <th>Membre</th><?php endif; ?>
                    <th>Livre</th>
                    <th>Exemplaire</th>
                    <th>Etat</th>
                    <th>Date emprunt</th>
                    <th>Date retour prévue</th>
                    <th>Date retour effective</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprunts as $e): ?>
                    <tr>
                        <td><?= $e['id_emprunt'] ?></td>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <td><?= $e['nom'] ?>         <?= $e['prenom'] ?></td>
                        <?php endif; ?>
                        <td><?= $e['titre'] ?? 'N/A' ?></td>
                        <td><?= $e['id_exemplaire'] ?></td>
                        <td><?= ucfirst($e['etat_exemplaire']) ?></td>
                        <td><?= $e['date_emprunt'] ?></td>
                        <td><?= $e['date_retour_prevue'] ?></td>
                        <td><?= $e['date_retour_effective'] ?? '-' ?></td>
                        <td><?= ucfirst($e['statut']) ?></td>
                        <td>
                            <?php if ($e['statut'] === 'en cours'): ?>
                                <a class="btn btn-return"
                                    href="../../controllers/empruntController.php?action=retour&id=<?= $e['id_emprunt'] ?>">Retour</a>
                            <?php else: ?>
                                <span class="btn btn-disabled">Aucune</span>
                            <?php endif; ?>

                            <!-- Bouton Ticket PDF -->
                            <a href="../exports/ticket_emprunt_pdf.php?id=<?= $e['id_emprunt'] ?>"
                                class="btn btn-info btn-sm" target="_blank">Ticket PDF</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>