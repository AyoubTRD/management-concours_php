<?php
$titre_document = "Inscription";
$titre_header = "Concours - Inscription";

include_once "components/header.php";

include_once "data/etablissements.php";

include_once $_SERVER["DOCUMENT_ROOT"] . "/utils/FileUploader.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/utils/PasswordManager.php";

include_once $_SERVER["DOCUMENT_ROOT"] . "/db/classes/Etudiant.php";

$erreurs = [];

if (isset($_POST["submit"])) {
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $mdpConfirmation = $_POST["mdp-confirmation"];
    $dateNaissance = $_POST["date-naissance"];
    $identiteRecto = $_FILES["identite-recto"];
    $identiteVerso = $_FILES["identite-verso"];
    $etablissement = $_POST["etablissement"];
    $diplome = $_POST["diplome"];
    $niveau = $_POST["niveau"];
    $cv = $_FILES["cv"];

    if ($mdpConfirmation != $mdp) {
        array_push($erreurs, "Confirmation du mot de passe incorrecte");
    }

    if (empty($erreurs)) {
        try {
            $etudiant = new Etudiant($db_connection);
            $fileUploader = new FileUploader();
            $passwordManager = new PasswordManager();

            $mdpHash = $passwordManager->hashPassword($mdp);
            $cvPath = $fileUploader->uploadFile($cv);
            $identiteRectoPath = $fileUploader->uploadFile($identiteRecto);
            $identiteVersoPath = $fileUploader->uploadFile($identiteVerso);

            $etudiant->insererEtudiant(
                $nom,
                $prenom,
                trim($email),
                $dateNaissance,
                $diplome,
                $niveau,
                $etablissement,
                $identiteRectoPath,
                $identiteVersoPath,
                $cvPath,
                trim($email),
                $mdpHash
            );

            $_SESSION["email"] = trim($email);

            $_SESSION["verification_pendante"] = true;
            header("Location: verification.php");
        } catch (Exception $e) {
            echo $e;
            array_push($erreurs, "Erreur: " . $e->getMessage());
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


  <form class="form-inscription" action="inscription.php" method="POST" enctype="multipart/form-data">
    <h5>Informations personnelles</h5>

    <div class="row">
      <div class="six columns">
        <label for="prenom">Prenom *</label>
        <input type="text" required name="prenom" id="prenom">
      </div>

      <div class="six columns">
        <label for="nom">Nom *</label>
        <input type="text" required name="nom" id="nom">
      </div>
    </div>

    <div>
      <label for="email">Email *</label>
      <input type="text" required name="email" id="email">
    </div>

    <div class="row">
      <div class="six columns">
        <label for="mdp">Mot de passe *</label>
        <input type="password" required id="mdp" name="mdp">
      </div>

      <div class="six columns">
        <label for="mdp-confirmation">Confirmation du mot de passe *</label>
        <input type="password" required id="mdp-confirmation" name="mdp-confirmation">
      </div>
    </div>

    <div>
      <label for="date-naissance">Date de naissance *</label>
      <input type="date" required name="date-naissance" id="date-naissance">
    </div>

    <br>

    <h5>Carte d'identite</h5>
    <div class="row">
      <div class="six columns">
        <label for="identite-recto">Recto *</label>
        <input type="file" name="identite-recto" required id="identite-recto" accept="image/jpeg,jpg,png">
      </div>

      <div class="six columns">
        <label for="identite-verso">Verso *</label>
        <input type="file" name="identite-verso" required id="identite-verso" accept="image/jpeg,jpg,png">
      </div>
    </div>

    <br>
    <h5>Education</h5>

    <div>
      <label for="etablissement">Etablissement</label>
      <select name="etablissement" id="etablissement">
        <option value=""></option>
        <?php foreach ($etablissements as $etablissement) {
            echo '<option value="' .
                $etablissement .
                '">' .
                $etablissement .
                "</option>";
        } ?>
      </select>
    </div>

    <div class="row">
      <div class="six columns">
        <label for="diplome">Diplome</label>
        <select name="diplome" id="diplome">
          <option value="Deug">Deug</option>
          <option value="License">License</option>
          <option value="Master">Master</option>
        </select>
      </div>

      <div class="six columns">
        <label for="niveau">Niveau</label>
        <select name="niveau" id="niveau">
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>
    </div>

    <div>
      <label for="cv">CV (PDF)</label>
      <input type="file" name="cv" id="cv" accept="application/pdf">
    </div>

    <br>
    <input name="submit" value="S'inscrire" type="submit"/>

    <br>
    <p><em>* Champs obligatoires</em></p>
  </form>

<?php include_once "components/footer.php";
