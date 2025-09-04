<?php
require_once "../../includes/auth.php";
require_once "../../config/db.php";
require_once "../../models/Utilisateur.php";

$database = new Database();
$db = $database->getConnection();
$utilisateur = new Utilisateur($db);

if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$user = $utilisateur->getById($id);

if(!$user) {
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $statut = $_POST['statut'];

    if($utilisateur->modifier($id, $nom, $prenom, $email, $role, $statut)) {
        header("Location: index.php?success=1");
        exit;
    } else {
        $error = "Erreur lors de la modification.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier utilisateur</title>
</head>
<body>
<h2>Modifier utilisateur</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    Nom: <input type="text" name="nom" value="<?= $user['nom'] ?>" required><br>
    Prénom: <input type="text" name="prenom" value="<?= $user['prenom'] ?>" required><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>" required><br>
    Rôle:
    <select name="role">
        <option value="membre" <?= $user['role']=='membre'?'selected':'' ?>>Membre</option>
        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
    </select><br>
    Statut:
    <select name="statut">
        <option value="actif" <?= $user['statut']=='actif'?'selected':'' ?>>Actif</option>
        <option value="inactif" <?= $user['statut']=='inactif'?'selected':'' ?>>Inactif</option>
    </select><br><br>
    <input type="submit" value="Modifier">
</form>
<a href="index.php">Retour</a>
</body>
</html>
