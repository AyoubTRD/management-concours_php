<?php
$titre_document = "Recapitulation";
$titre_header = "Concours - Recapitulation";

include_once "components/header.php";

if (!$est_etudiant) {
    header("Location: index.php");
}

include_once "db/classes/Etudiant.php";

$etudiant = new Etudiant($db_connection);

$inscription = $etudiant->getEtudiantParId($id_etudiant);
?>

<div class="recap">
    <a href='recap-pdf.php?id=<?php echo $inscription["id"]; ?>'>
        <button>
        Telecharger PDF
        </button>
    </a>

    <br>
    <br>

    <div class="row">
        <div class="three columns">
            <h6>Nom</h6>
            <p><?php echo $inscription["nom"]; ?></p>
        </div>
        <div class="three columns">
            <h6>Prenom</h6>
            <p><?php echo $inscription["prenom"]; ?></p>
        </div>
        <div class="three columns">
            <h6>Email</h6>
            <p><?php echo $inscription["email"]; ?></p>
        </div>
        <div class="three columns">
            <h6>Date de naissance</h6>
            <p><?php echo $inscription["date_naissance"]; ?></p>
        </div>
    </div>

    <div class="row">
        <div class="four columns">
            <h6>Etablissement</h6>
            <p><?php echo $inscription["etablissement"]; ?></p>
        </div>

        <div class="four columns">
            <h6>Diplome</h6>
            <p><?php echo $inscription["diplome"]; ?></p>
        </div>

        <div class="four columns">
            <h6>Niveau</h6>
            <p><?php echo $inscription["niveau"]; ?></p>
        </div>
    </div>

    <div class="row">
        <div class="six columns">
            <h6>Carte d'identite</h6>
            <div class="row">
                <img class="six columns" src="<?php echo $inscription[
                    "photo_identite_recto"
                ]; ?>" alt="Carte d'identite recto">
                <img class="six columns" src="<?php echo $inscription[
                    "photo_identite_verso"
                ]; ?>" alt="Carte d'identite verso">
            </div>
        </div>

        <div class="six columns">
            <h6>CV</h6>
            <p><a href="<?php echo $inscription["cv"]; ?>">Ouvrir</a></p>
        </div>
    </div>
</div>

<?php include_once "components/footer.php";
