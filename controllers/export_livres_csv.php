<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Livre.php";

session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin'){
    die("Accès refusé");
}

$database = new Database();
$db = $database->getConnection();
$livre = new Livre($db);

// récupérer tous les livres
$livres = $livre->lister()->fetchAll(PDO::FETCH_ASSOC);

// nom du fichier CSV
$filename = "livres_export_" . date('Ymd_His') . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$filename);

$output = fopen('php://output', 'w');

// entêtes
fputcsv($output, ['ID', 'Titre', 'Auteur', 'Année', 'Genre', 'Langue', 'Quantité']);

// données
foreach($livres as $row){
    fputcsv($output, [
        $row['id_livre'],
        $row['titre'],
        $row['auteur_nom'].' '.$row['auteur_prenom'],
        $row['annee_publication'],
        $row['genre'],
        $row['langue'],
        $row['quantite']
    ]);
}

fclose($output);
exit;
