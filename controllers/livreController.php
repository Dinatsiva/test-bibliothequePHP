<?php
require_once __DIR__ . "/../models/Livre.php";

class LivreController {
    private $model;

    public function __construct() {
        $this->model = new Livre();
    }

    public function index() {
        $stmt = $this->model->getAll();
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . "/../views/livres/index.php";
    }

    public function ajouter($data) {
        $this->model->titre = $data['titre'];
        $this->model->annee_publication = $data['annee_publication'];
        $this->model->genre = $data['genre'];
        $this->model->langue = $data['langue'];
        $this->model->isbn = $data['isbn'];
        $this->model->quantite = $data['quantite'];
        $this->model->id_auteur = $data['id_auteur'];

        $this->model->create();
        header("Location: index.php?action=livres");
    }
}
