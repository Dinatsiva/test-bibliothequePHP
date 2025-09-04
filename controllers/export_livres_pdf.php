<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Livre.php";
require_once __DIR__ . "/../vendor/fpdf/fpdf.php"; // chemin vers FPDF

session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin'){
    die("Accès refusé");
}

$database = new Database();
$db = $database->getConnection();
$livre = new Livre($db);

$livres = $livre->lister()->fetchAll(PDO::FETCH_ASSOC);

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

$pdf->Cell(10,10,'ID',1);
$pdf->Cell(60,10,'Titre',1);
$pdf->Cell(40,10,'Auteur',1);
$pdf->Cell(20,10,'Annee',1);
$pdf->Cell(30,10,'Genre',1);
$pdf->Cell(30,10,'Langue',1);
$pdf->Cell(15,10,'Qt',1);
$pdf->Ln();

$pdf->SetFont('Arial','',11);
foreach($livres as $row){
    $pdf->Cell(10,8,$row['id_livre'],1);
    $pdf->Cell(60,8,utf8_decode($row['titre']),1);
    $pdf->Cell(40,8,utf8_decode($row['auteur_nom'].' '.$row['auteur_prenom']),1);
    $pdf->Cell(20,8,$row['annee_publication'],1);
    $pdf->Cell(30,8,utf8_decode($row['genre']),1);
    $pdf->Cell(30,8,utf8_decode($row['langue']),1);
    $pdf->Cell(15,8,$row['quantite'],1);
    $pdf->Ln();
}

$pdf->Output('D', 'livres_export_'.date('Ymd_His').'.pdf');
exit;
