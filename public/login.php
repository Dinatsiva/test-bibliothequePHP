<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Connexion</h2>
    <?php if(isset($_GET['error'])) echo "<p style='color:red'>Email ou mot de passe incorrect</p>"; ?>
    <form action="controllers/utilisateurController.php" method="POST">
    <input type="hidden" name="action" value="login">
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" required>
        </div>
        <button type="submit">Se connecter</button>
    </form>
</div>
</body>
</html>
