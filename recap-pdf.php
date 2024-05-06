<?php

include_once "components/header_init.php";
include_once "packages/fpdf/fpdf.php";

if (!isset($_GET["id"])) {
    echo "Veuillez donner l'identifiant de l'inscription";
    exit();
}

if (!$est_authentifie || ($est_etudiant && $id_etudiant != $_GET["id"])) {
    echo "Vous n'avez pas l'acces";
    exit();
}

include_once "db/classes/Etudiant.php";

$etudiant = new Etudiant($db_connection);
$inscription = $etudiant->getEtudiantParId($_GET["id"]);

if (!$inscription) {
    echo "Identifiant invalid";
    exit();
}

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("Arial", "", 36);

$pdf->Cell(0, 40, "Rapport d'inscription", 0, 1);

$pdf->SetFont("Arial", "", 12);

$pdf->Cell(0, 10, "Nom: " . $inscription["nom"], 0, 1);
$pdf->Cell(0, 10, "Prenom: " . $inscription["prenom"], 0, 1);
$pdf->Cell(0, 10, "Email: " . $inscription["email"], 0, 1);
$pdf->Cell(0, 10, "Date de naissance: " . $inscription["date_naissance"], 0, 1);

$pdf->Cell(0, 10, "Etablissement: " . $inscription["etablissement"], 0, 1);
$pdf->Cell(0, 10, "Diplome: " . $inscription["diplome"], 0, 1);
$pdf->Cell(0, 10, "Niveau: " . $inscription["niveau"], 0, 1);

$pdf->Cell(0, 10, 'Carte d\'identite recto:', 0, 1);
$pdf->Image(
    $_SERVER["DOCUMENT_ROOT"] . $inscription["photo_identite_recto"],
    10,
    null,
    90
);
$pdf->Cell(0, 10, 'Carte d\'identite verso:', 0, 1);
$pdf->Image(
    $_SERVER["DOCUMENT_ROOT"] . $inscription["photo_identite_verso"],
    10,
    null,
    90
);

$pdf->Cell(
    0,
    10,
    "CV: Ouvrir",
    0,
    1,
    "",
    false,
    "http://" . $_SERVER["HTTP_HOST"] . $inscription["cv"]
);

$pdf->Output();
