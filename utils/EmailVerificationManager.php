<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/packages/fpdf/fpdf.php";

include_once $_SERVER["DOCUMENT_ROOT"] .
    "/packages/PHPMailer/src/PHPMailer.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/packages/PHPMailer/src/SMTP.php";
include_once $_SERVER["DOCUMENT_ROOT"] .
    "/packages/PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailVerificationManager
{
    // Méthode pour générer un token aléatoire
    public static function generateToken()
    {
        return bin2hex(random_bytes(16)); // Génère un token hexadécimal de 32 caractères
    }

    // Méthode pour envoyer un e-mail de vérification
    public static function sendVerificationEmail($to, $token)
    {
        $lien_verification =
            "http://" .
            $_SERVER["HTTP_HOST"] .
            "/verification.php?token=" .
            $token;

        // Create a new PHPMailer instance
        $mail = new PHPMailer();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Username = "ayoubtrdbuzzer@gmail.com"; // Your Gmail address
        $mail->Password = "rvai exxu chdy rjnm"; // Your Gmail password

        // Sender and recipient settings
        $mail->setFrom("ayoubtrdbuzzer@gmail.com", "Gestion Concours ENSA"); // Sender's email and name
        $mail->addAddress($to, $to); // Recipient's email and name

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Verification d'inscription au concours d'ENSA";
        $mail->Body = "Merci de cliquer le lien ci-dessous pour verfier votre email: <br>
            <a href='$lien_verification'>Cliquer ici</a>
            ";

        // Try to send the email
        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Email non enovye: {$mail->ErrorInfo}";
        }
    }
}
