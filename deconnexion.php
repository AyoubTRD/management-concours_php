<?php
$titre_document = "Deconnexion";
$titre_header = "Management Concours";

include_once "components/header.php";

if (!$est_authentifie) {
    header("Location: index.php");
}

if (isset($_POST["submit"])) {
    unset($_SESSION["user_id"]);
    unset($_SESSION["etudiant"]);
    unset($_SESSION["admin"]);
    unset($_SESSION["admin_id"]);

    header("Location: index.php");
}
?>

<h2>Deconnexion</h2>
<p>Veuillez confirmer la deconnexion</p>
<form method="post" action="deconnexion.php">
    <input type="submit" id="submit" name="submit" value="Confirmer">
</form>

<?php include_once "components/footer.php";
