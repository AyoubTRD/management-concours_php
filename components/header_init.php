<?php
session_start();
include_once $_SERVER["DOCUMENT_ROOT"] . "/db/classes/DB.php";

$db = new DB();
$db_connection = $db->connection;

$est_admin = isset($_SESSION["admin"]) && isset($_SESSION["admin_id"]);
$est_etudiant = isset($_SESSION["etudiant"]) && isset($_SESSION["user_id"]);
$est_authentifie = $est_admin || $est_etudiant;

if ($est_etudiant) {
    $id_etudiant = $_SESSION["user_id"];
}
