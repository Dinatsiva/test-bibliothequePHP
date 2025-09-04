<form method="POST" action="../../controllers/exemplaireController.php">
    <input type="hidden" name="action" value="ajouter">
    <label>Livre :</label>
    <select name="id_livre" required>
        <?php foreach($livres as $l): ?>
        <option value="<?= $l['id_livre'] ?>"><?= $l['titre'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>État :</label>
    <select name="etat">
        <option value="neuf">Neuf</option>
        <option value="bon" selected>Bon</option>
        <option value="usé">Usé</option>
        <option value="endommagé">Endommagé</option>
    </select>

    <label>Rayon :</label>
    <select name="id_rayon">
        <option value="">-- Aucun --</option>
        <?php foreach($rayons as $r): ?>
        <option value="<?= $r['id_rayon'] ?>"><?= $r['nom'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Ajouter</button>
</form>
