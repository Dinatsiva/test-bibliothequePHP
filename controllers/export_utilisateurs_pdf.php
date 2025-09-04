<?php
session_start();
require_once "../config/db.php";
require_once "../vendor/fpdf/fpdf.php";

if($_SESSION['user_role'] !== 'admin') exit('Accès refusé');

$database = new Database();
$db = $database->getConnection();

$stmt = $db->query("SELECT nom, prenom, email, role, statut, date_inscription FROM utilisateur");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Liste des utilisateurs',0,1,'C');

$pdf->SetFont('Arial','',10);
foreach($utilisateurs as $user){
    $pdf->Cell(0,8,implode(" | ", $user),0,1);
}

$pdf->Output('D', 'utilisateurs.pdf');
exit;
