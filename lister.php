<?php
$titre_header = "Concours - Liste";
$titre_document = "Liste d'inscription";

include_once "components/header.php";
include_once "db/classes/Etudiant.php";

$etudiant = new Etudiant($db_connection);
$inscriptions = $etudiant->getInscriptions();
?>

<form id="search-form">
    <input type="text" id="search" placeholder="Ayoub">

    <input type="submit" value="Rechercher">
</form>

<p style="display: none;" id="search-text"></p>

<div id="loading-container" style="display: none;">
    <img src="/public/loading-indicator.gif" alt="Loading...">
</div>


<table>
<thead>
    <th>
        N
    </th>
    <th>
        Email
    </th>
    <th>
        Nom
    </th>
    <th>
        Prenom
    </th>
    <th>
        Date Naissance
    </th>
    <th>
        Etablissement
    </th>
    <th>
        Diplome
    </th>
    <th>
        Niveau
    </th>
    <th>
        CV
    </th>
    <th>
        Carte d'identite
    </th>
</thead>
<tbody>
    <?php foreach ($inscriptions as $i) { ?>
    <tr>
            <td>
                <?php echo $i["id"]; ?>
            </td>
            <td>
                <?php echo $i["email"]; ?>
            </td>
            <td>
                <?php echo $i["nom"]; ?>
            </td>
            <td>
                <?php echo $i["prenom"]; ?>
            </td>
            <td>
                <?php echo $i["date_naissance"]; ?>
            </td>
            <td>
                <?php echo $i["etablissement"]; ?>
            </td>
            <td>
                <?php echo $i["diplome"]; ?>
            </td>
            <td>
                <?php echo $i["niveau"]; ?>
            </td>
            <td>
                <a href="<?php echo $i["cv"]; ?>" target="_blank">Ouvrir</a>
            </th>
            <td>
                    <div>
                        <a href="<?php echo $i[
                            "photo_identite_recto"
                        ]; ?>" target="_blank">Ouvrir Recto</a>
                    </div>
                    <div>
                        <a href="<?php echo $i[
                            "photo_identite_verso"
                        ]; ?>" target="_blank">Ouvrir Verso</a>
                    </div>
            </td>
        </tr>
        <?php } ?>
</tbody>
</table>

<script type="text/javascript" src="/public/lister.js"></script>

<?php include_once "components/footer.php";
