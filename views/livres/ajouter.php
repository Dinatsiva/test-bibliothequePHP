<?php include("../includes/header.php"); ?>
<div class="container mt-4">
    <h2>Ajouter un livre</h2>
    <form action="../../controllers/livreController.php" method="POST">
        <input type="hidden" name="action" value="ajouter">
        <div class="mb-3"><label>Titre</label><input type="text" name="titre" class="form-control" required></div>
        <div class="mb-3"><label>ID Auteur</label><input type="number" name="id_auteur" class="form-control"></div>
        <div class="mb-3"><label>Année Publication</label><input type="number" name="annee_publication" class="form-control"></div>
        <div class="mb-3"><label>Genre</label><input type="text" name="genre" class="form-control"></div>
        <div class="mb-3"><label>Langue</label><input type="text" name="langue" class="form-control"></div>
        <div class="mb-3"><label>ISBN</label><input type="text" name="isbn" class="form-control"></div>
        <div class="mb-3"><label>Quantité</label><input type="number" name="quantite" class="form-control" value="1"></div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
<?php include("../includes/footer.php"); ?>
