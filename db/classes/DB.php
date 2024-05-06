<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/config/db.php";

class DB
{
    public $connection;

    function __construct()
    {
        global $DB_HOST, $DB_NAME, $DB_PORT, $DB_USERNAME, $DB_PASSWORD;

        try {
            $this->connection = new PDO(
                "mysql:host=$DB_HOST:$DB_PORT;dbname=$DB_NAME",
                $DB_USERNAME,
                $DB_PASSWORD
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (Exception $e) {
            echo "<strong>J'ai utilise la configuration de base de donnees pour MAMP, si vous utilisez XAMPP ou un autre client veuillez changer la configuration dans `config/db.php`</strong><br>";
            echo $e->getMessage();
        }
    }
}
