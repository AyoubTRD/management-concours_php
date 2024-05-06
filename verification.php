<?php
$titre_document = "Verification Email";
$titre_header = "Concours - Verification";

include_once "components/header.php";

include_once $_SERVER["DOCUMENT_ROOT"] . "/utils/EmailVerificationManager.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/db/classes/Etudiant.php";

$etudiant = new Etudiant($db_connection);

if (isset($_GET["token"])) {
    if ($etudiant->validerUtilisateur($_GET["token"])) {
        unset($_SESSION["verification_pendante"]);
        header("Location: authentication.php");
    } else {
        echo "Lien invalid";
    }
}

if (!isset($_SESSION["email"]) || !isset($_SESSION["verification_pendante"])) {
    header("Location: index.php");
}

if (isset($_POST["resend_email"])) {
    $e = $etudiant->getEtudiantParEmail($_SESSION["email"]);
    if (!$e) {
        echo "Email invalid";
    } else {
        EmailVerificationManager::sendVerificationEmail(
            $e["email"],
            $e["token"]
        );
    }
}
?>

<h2>Inscription Reussie</h2>
<p>Nous avons envoye un email avec lien de verification, veuillez consulter votre email: <strong><?php echo $_SESSION[
    "email"
]; ?>
</strong></p>

<br>
<em>Pas recu d'email?</em>
<form method="POST" action="/verification.php">
    <input type="submit" name="resend_email" value="Re-envoyer email de verification">
</form>

<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/components/footer.php";
