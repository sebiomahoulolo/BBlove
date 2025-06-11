<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';

include '../db.php';

// Récupérer les données POST
$id = $_POST['id'] ?? null;
$date_rdv = $_POST['date_rdv'] ?? null;
$heure_rdv = $_POST['heure_rdv'] ?? null;
$mode = $_POST['mode'] ?? null;
$lien_ou_lieu = trim($_POST['lien_ou_lieu'] ?? '');
$payant = isset($_POST['payant']) ? 1 : 0;
$montant = $payant ? floatval($_POST['montant']) : 0;

// Vérifications basiques
if (!$id || !$date_rdv || !$heure_rdv || !$mode || !$lien_ou_lieu) {
    echo "Données manquantes. Veuillez remplir tous les champs obligatoires.";
    exit;
}

// Mettre à jour le RDV dans la base avec toutes les infos
$stmt = $pdo->prepare("UPDATE coaching_rdv SET 
    statut = 'confirmé',
    date_rdv = ?, 
    heure_rdv = ?, 
    mode = ?, 
    lieu_ou_lien = ?, 
    payant = ?, 
    montant = ? 
    WHERE rdv_id = ?");
$stmt->execute([$date_rdv, $heure_rdv, $mode, $lien_ou_lieu, $payant, $montant, $id]);

// Récupérer les infos RDV + utilisateur
$stmt = $pdo->prepare("SELECT * FROM coaching_rdv WHERE rdv_id = ?");
$stmt->execute([$id]);
$rdv = $stmt->fetch();

if (!$rdv) {
    echo "RDV introuvable après mise à jour.";
    exit;
}

// Préparer les infos pour l'email
$email = $rdv['email'];
$nom = htmlspecialchars($rdv['nom']);
$date = htmlspecialchars($rdv['date_rdv']);
$heure = htmlspecialchars($rdv['heure_rdv']);
$mode = htmlspecialchars($rdv['mode']);
$lieu_ou_lien = htmlspecialchars($rdv['lieu_ou_lien']);
$coach = $_SESSION['nom'] ?? 'Votre coach BBLove';

// Lien de paiement - à adapter selon ta gestion réelle
$link_paiement = "https://me.fedapay.com/bblove-surprise";

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hosanaconsulting@gmail.com'; // change ici
    $mail->Password = 'eqqi ahhv cuwd mlbr'; // mot de passe d’application
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('hosanaconsulting@gmail.com', 'BBLove');
    $mail->addAddress($email, $nom);

    $mail->isHTML(true);
    $mail->Subject = "✅ Confirmation de votre rendez-vous avec $coach";

    // Construire le corps du mail
    $body = "
    <p>Bonjour <strong>$nom</strong>,</p>
    <p>Votre rendez-vous de coaching avec <strong>$coach</strong> a été confirmé :</p>
    <ul>
      <li>📅 <strong>$date</strong></li>
      <li>⏰ <strong>$heure</strong></li>
      <li>📍 <strong>" . ($mode === 'en ligne' ? 'Lien de la réunion' : 'Adresse du lieu') . " :</strong> $lieu_ou_lien</li>
    </ul>";

    if ($payant && $montant > 0) {
        $body .= "
        <p>💰 Montant à régler : <strong>" . number_format($montant, 0, ',', ' ') . " FCFA</strong></p>
        <p><a href='$link_paiement' style='
            display: inline-block; 
            padding: 12px 24px; 
            background-color: #ff5a5f; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px;'>Payer maintenant</a></p>";
    }

    $body .= "
    <p>Nous vous remercions pour votre confiance.</p>
    <p>❤️ L’équipe BBLove</p>
    ";

    $mail->Body = $body;

    $mail->send();
} catch (Exception $e) {
    // Ici tu peux loguer l'erreur si tu veux : $mail->ErrorInfo
    // Ne pas afficher l’erreur à l’utilisateur pour plus de sécurité
}

// Redirection après traitement
header("Location: ../coach_dashboard.php?page=rdv");
exit;
