<?php
include'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hosanaconsulting@gmail.com'; // Ton email
    $mail->Password = 'eqqi ahhv cuwd mlbr'; // Mot de passe d'application (pas le mot de passe Gmail)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('hosanaconsulting@gmail.com', 'BBLove - Coaching');
    $mail->addAddress($_POST['email'], $_POST['nom']);

    $mail->isHTML(true);
    $mail->Subject = 'Confirmation de votre réservation de coaching';
    $mail->Body = "
        Bonjour <strong>{$_POST['nom']}</strong>,<br><br>
        Merci pour votre réservation à une séance de coaching.<br>
        <strong>Type de séance :</strong> {$_POST['type_seance']}<br>
        <strong>Message :</strong> " . nl2br(htmlspecialchars($_POST['message'])) . "<br><br>
        Nous vous contacterons rapidement pour fixer la date précise de votre séance.<br><br>
        ❤️ L'équipe BBLove.
    ";

    $mail->send();

} catch (Exception $e) {
    // Tu peux loguer l'erreur ou afficher un message
}

?>
