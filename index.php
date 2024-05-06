<?php

$titre_document = "Accueil";
$titre_header = "Accueil";

include_once "components/header.php";

if (isset($_SESSION["verification_pendante"])) {
    header("Location: verification.php");
}

if ($est_admin) {
    header("Location: administration.php");
}

if ($est_etudiant) {
    header("Location: recap.php");
}

if (!$est_authentifie) {
    header("Location: authentication.php");
}
