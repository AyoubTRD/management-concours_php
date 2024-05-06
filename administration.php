<?php
$titre_header = "Concours - Administration";
$titre_document = "Administration";

include_once "components/header.php";
?>

<h2>Administration</h2>
<p>Bonjour admin, qu'est ce que vous aimeriez faire aujourd'hui?</p>

<a href="lister.php">
    <button>
        Lister
    </button>
</a>

<?php include_once "components/footer.php";
