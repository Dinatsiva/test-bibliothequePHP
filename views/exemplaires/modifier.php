<form method="POST" action="../../controllers/exemplaireController.php">
    <input type="hidden" name="action" value="modifier">
    <input type="hidden" name="id_exemplaire" value="<?= $ex['id_exemplaire'] ?>">

    <label>État :</label>
    <select name="etat">
        <option value="neuf" <?= $ex['etat']=='neuf'?'selected':'' ?>>Neuf</option>
        <option value="bon" <?= $ex['etat']=='bon'?'selected':'' ?>>Bon</option>
        <option value="usé" <?= $ex['etat']=='usé'?'selected':'' ?>>Usé</option>
        <option value="endommagé" <?= $ex['etat']=='endommagé'?'selected':'' ?>>Endommagé</option>
    </select>

    <label>Disponibilité :</label>
    <select name="disponible">
        <option value="oui" <?= $ex['disponible']=='oui'?'selected':'' ?>>Oui</option>
        <option value="non" <?= $ex['disponible']=='non'?'selected':'' ?>>Non</option>
    </select>

    <label>Rayon :</label>
    <select name="id_rayon">
        <option value="">-- Aucun --</option>
        <?php foreach($rayons as $r): ?>
        <option value="<?= $r['id_rayon'] ?>" <?= $r['id_rayon']==$ex['id_rayon']?'selected':'' ?>><?= $r['nom'] ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Modifier</button>
</form>
