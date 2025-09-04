<?php
require_once __DIR__ . "/../models/Utilisateur.php";

class UtilisateurController {
    private $model;

    public function __construct() {
        $this->model = new Utilisateur();
    }

    public function login($email, $mot_de_passe) {
        $utilisateur = $this->model->findByEmail($email);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
            $_SESSION['utilisateur'] = [
                "id" => $utilisateur['id_utilisateur'],
                "nom" => $utilisateur['nom'],
                "prenom" => $utilisateur['prenom'],
                "role" => $utilisateur['role']
            ];
            header("Location: dashboard.php");
        } else {
            echo "Email ou mot de passe incorrect";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
}
