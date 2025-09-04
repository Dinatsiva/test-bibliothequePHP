<?php
session_start();
require_once __DIR__ . "/../../includes/auth.php"; // Vérifie si connecté
require_once __DIR__ . "/../../controllers/empruntController.php";

// Récupérer tous les livres
$livres_disponibles = $livre->lister()->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nouvel emprunt</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .success { background: #d4edda; padding: 10px; margin-bottom: 15px; color: #155724; border-radius: 5px; }
        .error { background: #f8d7da; padding: 10px; margin-bottom: 15px; color: #721c24; border-radius: 5px; }
        form { max-width: 500px; margin: auto; }
        label { display: block; margin-top: 10px; }
        select, input[type="date"], button { width: 100%; padding: 8px; margin-top: 5px; }
        button { background: #007bff; color: #fff; border: none; cursor: pointer; border-radius: 3px; }
    </style>
    <script>
        function fetchExemplaires() {
            let livreId = document.getElementById('id_livre').value;
            fetch('../../controllers/empruntController.php?action=getExemplaires&id_livre=' + livreId)
                .then(response => response.json())
                .then(data => {
                    let select = document.getElementById('id_exemplaire');
                    select.innerHTML = '';
                    data.forEach(ex => {
                        let option = document.createElement('option');
                        option.value = ex.id_exemplaire;
                        option.text = ex.id_exemplaire + ' - ' + ex.etat;
                        select.appendChild(option);
                    });
                });
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Nouvel emprunt</h2>

    <?php if(isset($_GET['success'])): ?>
        <div class="success">Emprunt ajouté avec succès !</div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div class="error">Impossible d’emprunter : exemplaire indisponible.</div>
    <?php endif; ?>

    <form method="POST" action="../../controllers/empruntController.php">
        <input type="hidden" name="action" value="ajouter">
        <input type="hidden" name="id_utilisateur" value="<?= $_SESSION['user_id'] ?>">

        <label for="id_livre">Choisir un livre :</label>
        <select id="id_livre" name="id_livre" onchange="fetchExemplaires()" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach($livres_disponibles as $livre): ?>
                <option value="<?= $livre['id_livre'] ?>"><?= $livre['titre'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="id_exemplaire">Choisir un exemplaire :</label>
        <select id="id_exemplaire" name="id_exemplaire" required>
            <option value="">-- Sélectionner un livre d’abord --</option>
        </select>

        <label for="date_retour_prevue">Date de retour prévue :</label>
        <input type="date" name="date_retour_prevue" required>

        <button type="submit">Emprunter</button>
    </form>
</div>
</body>
</html>
