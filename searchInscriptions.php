<?php
include_once "components/header_init.php";

header("Content-Type: application/json; charset=utf-8");
$search = $_GET["search"];

include_once "db/classes/Etudiant.php";

$etudiant = new Etudiant($db_connection);

$resultats = $etudiant->getInscriptionsParSearch($search);

echo json_encode($resultats);
