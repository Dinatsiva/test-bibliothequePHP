<?php
require_once "../../includes/auth.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Auteur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2>Ajouter un Auteur</h2>
    <form method="POST" action="../../controllers/auteurController.php">
        <input type="hidden" name="action" value="ajouter">
        <label>Nom:</label><br>
        <input type="text" name="nom" required><br>
        <label>Prénom:</label><br>
        <input type="text" name="prenom"><br>
        <label>Nationalité:</label><br>
        <input type="text" name="nationalite"><br>
        <label>Date de Naissance:</label><br>
        <input type="date" name="date_naissance" required><br>
        <label>Date de Décès:</label><br>
        <input type="date" name="date_deces"><br><br>
        <button type="submit">Ajouter</button>
    </form>
</div>
</body>
</html>
