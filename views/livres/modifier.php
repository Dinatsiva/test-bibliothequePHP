<?php
include("../includes/header.php");
require_once "../../controllers/livreController.php";

if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$id = $_GET['id'];
$book = $livre->getById($id);
?>
<div class="container mt-4">
    <h2>Modifier le livre</h2>
    <form action="../../controllers/livreController.php" method="POST">
        <input type="hidden" name="action" value="modifier">
        <input type="hidden" name="id_livre" value="<?= $book['id_livre'] ?>">
        <div class="mb-3"><label>Titre</label><input type="text" name="titre" class="form-control" value="<?= $book['titre'] ?>" required></div>
        <div class="mb-3"><label>ID Auteur</label><input type="number" name="id_auteur" class="form-control" value="<?= $book['id_auteur'] ?>"></div>
        <div class="mb-3"><label>Année Publication</label><input type="number" name="annee_publication" class="form-control" value="<?= $book['annee_publication'] ?>"></div>
        <div class="mb-3"><label>Genre</label><input type="text" name="genre" class="form-control" value="<?= $book['genre'] ?>"></div>
        <div class="mb-3"><label>Langue</label><input type="text" name="langue" class="form-control" value="<?= $book['langue'] ?>"></div>
        <div class="mb-3"><label>ISBN</label><input type="text" name="isbn" class="form-control" value="<?= $book['isbn'] ?>"></div>
        <div class="mb-3"><label>Quantité</label><input type="number" name="quantite" class="form-control" value="<?= $book['quantite'] ?>"></div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
<?php include("../includes/footer.php"); ?>
