<?php

$titre_header = "Concours - Authentication";
$titre_document = "Authentication";

include_once "components/header.php";

include_once "db/classes/Etudiant.php";
include_once "db/classes/Admin.php";

$erreurs = [];

if ($est_authentifie) {
    header("Location: index.php");
}

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $comme_admin = isset($_POST["admin"]);

    if ($comme_admin) {
        $admin = new Admin($db_connection);
        $resultat = $admin->login($email, $password);

        if ($resultat) {
            $_SESSION["admin"] = true;
            $_SESSION["admin_id"] = $resultat["id"];

            header("Location: index.php");
        } else {
            array_push($erreurs, "Email ou mot de passe incorrect");
        }
    } else {
        $etudiant = new Etudiant($db_connection);
        $resultat = $etudiant->login($email, $password);

        if ($resultat) {
            $_SESSION["etudiant"] = true;
            $_SESSION["user_id"] = $resultat["id"];

            header("Location: index.php");
        } else {
            array_push($erreurs, "Email ou mot de passe incorrect");
        }
    }
}

if (!empty($erreurs)) { ?>

    <div class="erreur">
        <ul>
            <?php foreach ($erreurs as $e) {
                echo "<li>$e</li>";
            } ?>
        </ul>
    </div>
  <?php }
?>

<div class="authentication">
    <form method="post" action="authentication.php">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>

        <div>
            <input type="checkbox" id="admin" name="admin">
            <label for="admin">Je suis un admin</label>
        </div>

        <input type="submit" value="S'authentifier" name="submit">
    </form>
</div>

<?php include_once "components/footer.php";
