<?php
session_start();
require_once "../../controllers/empruntController.php";
require_once "../../config/db.php";

// Connexion pour récupérer les exemplaires disponibles
$database = new Database();
$db = $database->getConnection();
$query = $db->prepare("SELECT e.id_exemplaire, l.titre, e.etat 
                       FROM exemplaire e
                       JOIN livre l ON e.id_livre = l.id_livre
                       WHERE e.disponible='oui'");
$query->execute();
$exemplaires = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Nouvel emprunt</h2>

<form method="POST" action="../../controllers/empruntController.php">
    <input type="hidden" name="action" value="emprunter">
    
    <label for="id_exemplaire">Choisir un exemplaire :</label>
    <select name="id_exemplaire" required>
        <?php foreach($exemplaires as $ex): ?>
            <option value="<?= $ex['id_exemplaire'] ?>">
                <?= $ex['titre'] ?> (<?= $ex['etat'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="date_retour_prevue">Date de retour prévue :</label>
    <input type="date" name="date_retour_prevue" required>
    <br><br>

    <button type="submit">Emprunter</button>
</form>
