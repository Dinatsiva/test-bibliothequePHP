<?php
session_start();
require_once "../config/db.php";

if($_SESSION['user_role'] !== 'admin') exit('Accès refusé');

$database = new Database();
$db = $database->getConnection();

$stmt = $db->query("SELECT nom, prenom, email, role, statut, date_inscription FROM utilisateur");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="utilisateurs.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array_keys($utilisateurs[0]));
foreach($utilisateurs as $user) {
    fputcsv($output, $user);
}
fclose($output);
exit;
