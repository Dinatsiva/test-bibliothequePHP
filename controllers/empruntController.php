<?php
session_start();
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Emprunt.php";
require_once __DIR__ . "/../models/Exemplaire.php";

$database = new Database();
$db = $database->getConnection();

$emprunt = new Emprunt($db);
$exemplaire = new Exemplaire($db);

// AJOUTER UN EMPRUNT
if(isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $id_exemplaire = $_POST['id_exemplaire'];
    $id_utilisateur = $_SESSION['user_id'];
    $date_emprunt = date('Y-m-d');
    $date_retour_prevue = date('Y-m-d', strtotime('+14 days')); // retour prévu 2 semaines

    // Vérifier si l’exemplaire est disponible
    $ex = $exemplaire->getById($id_exemplaire);
    if($ex && $ex['disponible'] === 'oui') {
        $emprunt->ajouter($id_utilisateur, $id_exemplaire, $date_emprunt, $date_retour_prevue);
        $exemplaire->modifier($id_exemplaire, $ex['etat'], 'non', $ex['id_rayon']); // rendre indisponible
        header("Location: ../views/emprunts/index.php?success=1");
    } else {
        header("Location: ../views/emprunts/index.php?error=1");
    }
    exit;
}

// RETOUR DE LIVRE
if(isset($_GET['action']) && $_GET['action'] === 'retour' && isset($_GET['id'])) {
    $id_emprunt = $_GET['id'];
    $em = $emprunt->getById($id_emprunt);
    if($em) {
        $date_retour = date('Y-m-d');
        $statut = ($date_retour > $em['date_retour_prevue']) ? 'en retard' : 'retourné';
        $emprunt->retour($id_emprunt, $date_retour, $statut);
        $exemplaire->modifier($em['id_exemplaire'], $em['etat_exemplaire'], 'oui', $em['id_rayon']); // disponible
    }
    header("Location: ../views/emprunts/index.php?success=1");
    exit;
}

// LISTER LES EMPRUNTS
if($_SESSION['user_role'] === 'admin') {
    $emprunts = $emprunt->lister()->fetchAll(PDO::FETCH_ASSOC);
} else {
    $emprunts = $emprunt->listerParUtilisateur($_SESSION['user_id'])->fetchAll(PDO::FETCH_ASSOC);
}
if(isset($_GET['action']) && $_GET['action'] === 'recherche' && isset($_GET['q'])) {
    $q = $_GET['q'];
    $resultats = $objet->rechercher($q)->fetchAll(PDO::FETCH_ASSOC);
} else {
    $resultats = $objet->lister()->fetchAll(PDO::FETCH_ASSOC);
}

?>
