<?php
session_start();

// Inclusion de la config (connexion DB)
require_once __DIR__ . '/../config/db.php';

// Chargement automatique des modèles et contrôleurs
spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . "/../models/$class.php")) {
        require_once __DIR__ . "/../models/$class.php";
    } elseif (file_exists(__DIR__ . "/../controllers/{$class}.php")) {
        require_once __DIR__ . "/../controllers/{$class}.php";
    }
});

// Récupération de l’action
$action = $_GET['action'] ?? 'home';

// Routage simple
switch ($action) {
    case 'login':
        require_once __DIR__ . '/../controllers/utilisateurController.php';
        $controller = new UtilisateurController();
        $controller->login();
        break;
    case 'register':
        require_once __DIR__ . '/../controllers/utilisateurController.php';
        $controller = new UtilisateurController();
        $controller->register();
        break;
    case 'logout':
        require_once __DIR__ . '/../controllers/utilisateurController.php';
        $controller = new UtilisateurController();
        $controller->logout();
        break;
    default:
        include __DIR__ . '/../views/home.php';
        break;
}
