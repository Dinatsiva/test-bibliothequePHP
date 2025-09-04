<?php
require_once "../../includes/auth.php";
require_once "../../models/Auteur.php";
require_once "../../config/db.php";

$database = new Database();
$db = $database->getConnection();
$auteurModel = new Auteur($db);

$id_auteur = $_GET['id'];
$auteur = $auteurModel->getById($id_auteur);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier Auteur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2>Modifier Auteur</h2>
    <form method="POST" action="../../controllers/auteurController.php">
        <input type="hidden" name="action" value="modifier">
        <input type="hidden" name="id_auteur" value="<?= $auteur['id_auteur'] ?>">
        <label>Nom:</label><br>
        <input type="text" name="nom" value="<?= $auteur['nom'] ?>" required><br>
        <label>Prénom:</label><br>
        <input type="text" name="prenom" value="<?= $auteur['prenom'] ?>"><br>
        <label>Nationalité:</label><br>
        <input type="text" name="nationalite" value="<?= $auteur['nationalite'] ?>"><br>
        <label>Date de Naissance:</label><br>
        <input type="date" name="date_naissance" value="<?= $auteur['date_naissance'] ?>" required><br>
        <label>Date de Décès:</label><br>
        <input type="date" name="date_deces" value="<?= $auteur['date_deces'] ?>"><br><br>
        <button type="submit">Modifier</button>
    </form>
</div>
</body>
</html>
