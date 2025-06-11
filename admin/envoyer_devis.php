<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';
require '../PHPMailer/PHPMailer/src/Exception.php';
require '../db.php';

// Récupère l'ID de la commande
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "❌ ID de commande manquant.";
    exit;
}

// Récupère la commande
$stmt = $pdo->prepare("SELECT * FROM commandes_surprise WHERE id = ?");
$stmt->execute([$id]);
$commande = $stmt->fetch();

if (!$commande) {
    echo "❌ Commande introuvable.";
    exit;
}

// Récupération des données
$to   = $commande['expediteur_email'];
$nom  = $commande['expediteur_nom'];
$type = $commande['type_surprise'];
$date = $commande['date_livraison'];
$heure = $commande['heure_livraison'];
$messagePerso = $commande['message'] ?? '(Aucun message)';
$montantTotal = $commande['montant_total'] ?? 0;
$details = json_decode($commande['devis'], true);

// Génère le HTML du tableau du devis
$detailsHtml = "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse; font-size:14px;'>
<thead>
<tr><th>Désignation</th><th>Montant (FCFA)</th></tr>
</thead><tbody>";

foreach ($details as $label => $value) {
    if ($label === 'montant_total') continue;
    $labelNice = ucfirst(str_replace('_', ' ', $label));
    $detailsHtml .= "<tr><td>$labelNice</td><td>" . number_format($value, 0, ',', ' ') . "</td></tr>";
}
$detailsHtml .= "<tr><td><strong>Total</strong></td><td><strong>" . number_format($montantTotal, 0, ',', ' ') . "</strong></td></tr>";
$detailsHtml .= "</tbody></table>";

// Envoi email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hosanaconsulting@gmail.com';
    $mail->Password = 'eqqi ahhv cuwd mlbr'; // mot de passe d’application
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('hosanaconsulting@gmail.com', 'BBLove');
    $mail->addAddress($to, $nom);
    $mail->isHTML(true);
    $mail->Subject = "💌 Votre devis personnalisé pour la surprise BBLove";

    $mail->Body = "
        Bonjour <strong>$nom</strong>,<br><br>
        Merci pour votre confiance. Voici votre devis détaillé pour la commande surprise du <strong>$date à $heure</strong> :<br><br>

        <strong>🎁 Type :</strong> $type<br>
        <strong>📝 Message :</strong> <em>$messagePerso</em><br><br>

        $detailsHtml

        <br><strong>Total à payer : " . number_format($montantTotal, 0, ',', ' ') . " FCFA</strong><br><br>

        ➡️ Cliquez ici pour procéder au paiement :<br>
        <a href='https://paiement.bblove.bj/commande?id=$id' style='color:#d00000;'>https://paiement.bblove.bj/commande?id=$id</a><br><br>

        ❤️ L’équipe BBLove.
    ";

    $mail->send();

    // Mise à jour du statut
    $pdo->prepare("UPDATE commandes_surprise SET statut = 'envoyé' WHERE id = ?")->execute([$id]);

    echo "✅ Devis envoyé avec succès à $to";
} catch (Exception $e) {
    echo "❌ L'envoi du mail a échoué : " . $mail->ErrorInfo;
}
?>
