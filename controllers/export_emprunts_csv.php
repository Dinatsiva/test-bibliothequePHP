<?php
session_start();
require_once "../config/db.php";

if($_SESSION['user_role'] !== 'admin') exit('Accès refusé');

$database = new Database();
$db = $database->getConnection();

$sql = "SELECT e.id_emprunt, u.nom AS membre_nom, u.prenom AS membre_prenom, 
               l.titre AS livre_titre, e.date_emprunt, e.date_retour_prevue, e.date_retour_effective, e.statut
        FROM emprunt e
        JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
        JOIN livre l ON e.id_livre = l.id_livre";
$stmt = $db->query($sql);
$emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="emprunts.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array_keys($emprunts[0]));
foreach($emprunts as $emprunt) {
    fputcsv($output, $emprunt);
}
fclose($output);
exit;
