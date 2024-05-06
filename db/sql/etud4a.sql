CREATE TABLE etud4a (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(128),
    prenom VARCHAR(128),
    email VARCHAR(128),
    date_naissance DATE,
    diplome VARCHAR(64),
    niveau INT,
    etablissement VARCHAR(256),
    photo_identite_recto VARCHAR(1024),
    photo_identite_verso VARCHAR(1024),
    cv VARCHAR(1024),
    log VARCHAR(128),
    mdp VARCHAR(256),
    token VARCHAR(255),
    valide INT DEFAULT 0
)
