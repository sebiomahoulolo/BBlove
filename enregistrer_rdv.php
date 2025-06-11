<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';
require '../PHPMailer/PHPMailer/src/Exception.php';
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coach_id = $_SESSION['user_id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $categorie = $_POST['categorie'];
    $date = $_POST['date_rdv'];
    $heure = $_POST['heure_rdv'];
    $jitsi = $_POST['lien_jitsi'];

    $stmt = $pdo->prepare("INSERT INTO rdv_coach_contact (coach_id, utilisateur_nom, utilisateur_email, utilisateur_tel, categorie, date_rdv, heure_rdv, lien_jitsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$coach_id, $nom, $email, $tel, $categorie, $date, $heure, $jitsi]);

    // Envoi mail
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hosanaconsulting@gmail.com';
        $mail->Password = 'eqqi ahhv cuwd mlbr';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('hosanaconsulting@gmail.com', 'BBLove');
        $mail->addAddress($email, $nom);
        $mail->isHTML(true);
        $mail->Subject = "Confirmation de votre RDV avec le coach";

        $mail->Body = "
            Bonjour <strong>$nom</strong>,<br><br>
            Votre rendez-vous a été confirmé.<br>
            <strong>Date :</strong> $date<br>
            <strong>Heure :</strong> $heure<br>
            <strong>Catégorie :</strong> $categorie<br><br>
            Cliquez ici pour accéder à la séance : <a href='$jitsi'>$jitsi</a><br><br>
            À bientôt sur BBLove !
        ";

        $mail->send();
        echo "✅ RDV enregistré et mail envoyé.";
    } catch (Exception $e) {
        echo "❌ Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
    }
}
?>
