<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/utils/EmailVerificationManager.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/utils/PasswordManager.php";

class Etudiant
{
    private $db_connection;

    function __construct($db_connection)
    {
        $this->db_connection = $db_connection;
    }

    function getEtudiantParId($id)
    {
        $statement = $this->db_connection->prepare(
            "SELECT *
            FROM etud3a WHERE id = :id
        "
        );
        $statement->execute([":id" => $id]);
        $resultat = $statement->fetch();

        return $resultat;
    }

    function getEtudiantParEmail($email)
    {
        $statement = $this->db_connection->prepare(
            "SELECT *
            FROM etud3a WHERE email = :email
        "
        );
        $statement->execute([":email" => $email]);
        $resultat = $statement->fetch();

        return $resultat;
    }

    function insererEtudiant(
        $nom,
        $prenom,
        $email,
        $naissance,
        $diplome,
        $niveau,
        $etablissement,
        $photoIdentiteRecto,
        $photoIdentiteVerso,
        $cv,
        $log,
        $mdp
    ) {
        // Préparation de la requête d'insertion
        $sql = "INSERT INTO etud3a (nom, prenom, email, date_naissance, diplome, niveau, etablissement, photo_identite_recto, photo_identite_verso, cv, log, mdp, token)
                VALUES (:nom, :prenom, :email, :naissance, :diplome, :niveau, :etablissement, :photo_identite_recto, :photo_identite_verso, :cv, :log, :mdp, :token)";

        // Préparation de la requête
        $stmt = $this->db_connection->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":naissance", $naissance);
        $stmt->bindParam(":diplome", $diplome);
        $stmt->bindParam(":niveau", $niveau);
        $stmt->bindParam(":etablissement", $etablissement);
        $stmt->bindParam(":photo_identite_recto", $photoIdentiteRecto);
        $stmt->bindParam(":photo_identite_verso", $photoIdentiteVerso);
        $stmt->bindParam(":cv", $cv);
        $stmt->bindParam(":log", $log);
        $stmt->bindParam(":mdp", $mdp);

        $token = EmailVerificationManager::generateToken();
        $stmt->bindParam(":token", $token);

        // Exécution de la requête
        $stmt->execute();

        EmailVerificationManager::sendVerificationEmail($email, $token);

        // Retourne l'ID de l'enregistrement inséré
        return $this->db_connection->lastInsertId();
    }

    function validerUtilisateur($token)
    {
        // Préparation de la requête de validation
        $sql = "UPDATE etud3a SET valide = 1 WHERE token = :token";

        // Préparation de la requête
        $stmt = $this->db_connection->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(":token", $token);

        // Exécution de la requête
        $stmt->execute();

        // Vérification du nombre de lignes affectées
        if ($stmt->rowCount() > 0) {
            return true; // Utilisateur validé avec succès
        } else {
            return false; // Aucun utilisateur trouvé avec ce token
        }
    }

    function login($email, $mdp)
    {
        $passwordManager = new PasswordManager();
        $etudiant = $this->getEtudiantParEmail($email);
        if (!$etudiant) {
            return false;
        }
        $valide = $passwordManager->verifyPasswordAgainstHash(
            $mdp,
            $etudiant["mdp"]
        );

        if (!$valide) {
            return false;
        }

        return $etudiant;
    }

    function getInscriptions()
    {
        $sql = "
            SELECT * FROM etud3a WHERE valide = 1
        ";
        $stmt = $this->db_connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    function getInscriptionsParSearch($search)
    {
        $sql = "SELECT * FROM etud3a
                WHERE valide = 1
                AND (LOWER(nom) LIKE :searchTerm
                OR LOWER(prenom) LIKE :searchTerm
                OR LOWER(email) LIKE :searchTerm
                OR LOWER(etablissement) LIKE :searchTerm)";
        $stmt = $this->db_connection->prepare($sql);
        $s = "%$search%";

        $stmt->bindParam(":searchTerm", $s, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
