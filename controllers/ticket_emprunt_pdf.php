<?php
session_start();
require_once "../config/db.php";
require_once "../vendor/fpdf/fpdf.php";

if(!isset($_GET['id'])) exit('Emprunt introuvable');

$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare("SELECT e.id_emprunt, u.nom AS membre_nom, u.prenom AS membre_prenom, 
                             l.titre AS livre_titre, e.date_emprunt, e.date_retour_prevue, e.statut
                      FROM emprunt e
                      JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur
                      JOIN livre l ON e.id_livre = l.id_livre
                      WHERE e.id_emprunt = :id");
$stmt->bindParam(":id", $_GET['id']);
$stmt->execute();
$emprunt = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$emprunt) exit('Emprunt introuvable');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Ticket de prêt',0,1,'C');

$pdf->SetFont('Arial','',12);
foreach($emprunt as $key => $value){
    $pdf->Cell(50,8,ucfirst(str_replace('_',' ',$key)),0,0);
    $pdf->Cell(0,8,$value,0,1);
}

$pdf->Output('D', 'ticket_emprunt_'.$emprunt['id_emprunt'].'.pdf');
exit;
