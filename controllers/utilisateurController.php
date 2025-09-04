<?php
class UtilisateurController {
    private $db;
    private $utilisateurModel;

    public function __construct() {
        require_once __DIR__ . '/../config/db.php';
        $this->db = (new Database())->getConnection();
        require_once __DIR__ . '/../models/Utilisateur.php';
        $this->utilisateurModel = new Utilisateur($this->db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';

            $user = $this->utilisateurModel->findByEmail($email);

            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $error = "Identifiants incorrects";
            }
        }
        include __DIR__ . '/../views/utilisateurs/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->utilisateurModel->create($_POST);
            header("Location: index.php?action=login");
            exit;
        }
        include __DIR__ . '/../views/utilisateurs/register.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
