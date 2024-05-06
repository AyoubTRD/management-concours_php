CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(256),
    mdp VARCHAR(256)
);

INSERT INTO admin (email, mdp) VALUES ('admin@exemple.com', 'password');
INSERT INTO admin (email, mdp) VALUES ('admin2@exemple.com', 'password');
