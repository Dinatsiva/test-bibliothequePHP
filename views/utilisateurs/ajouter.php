<?php
require_once "../../includes/auth.php";
require_once "../../config/db.php";
require_once "../../models/Utilisateur.php";

$database = new Database();
$db = $database->getConnection();
$utilisateur = new Utilisateur($db);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = $_POST['role'] ?? 'membre';

    if($utilisateur->ajouter($nom, $prenom, $email, $mot_de_passe, $role)) {
        header("Location: index.php?success=1");
        exit;
    } else {
        $error = "Erreur lors de l'ajout.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter utilisateur</title>
</head>
<body>
<h2>Ajouter un utilisateur</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    Nom: <input type="text" name="nom" required><br>
    Prénom: <input type="text" name="prenom" required><br>
    Email: <input type="email" name="email" required><br>
    Mot de passe: <input type="password" name="mot_de_passe" required><br>
    Rôle:
    <select name="role">
        <option value="membre">Membre</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <input type="submit" value="Ajouter">
</form>
<a href="index.php">Retour</a>
</body>
</html>
