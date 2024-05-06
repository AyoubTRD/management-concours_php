<?php

class Admin
{
    private $db_connection;

    function __construct($connection)
    {
        $this->db_connection = $connection;
    }

    function login($email, $mdp)
    {
        $stmt = $this->db_connection->prepare("
            SELECT * FROM admin WHERE email = :email AND mdp = :mdp
        ");

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":mdp", $mdp);

        $stmt->execute();
        return $stmt->fetch();
    }
}
