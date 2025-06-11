<?php
include '../db.php';
session_start();
$mon_id = $_SESSION['user_id'];
$ami_id = $_GET['to'] ?? null;

if (!$ami_id || $mon_id == $ami_id) {
    exit;
}

// Récupérer tous les messages
$stmt = $pdo->prepare("SELECT * FROM messages 
    WHERE (expediteur_id = ? AND destinataire_id = ?) 
       OR (expediteur_id = ? AND destinataire_id = ?) 
    ORDER BY date_envoi ASC");
$stmt->execute([$mon_id, $ami_id, $ami_id, $mon_id]);
$messages = $stmt->fetchAll();

// Affichage HTML pour injecter dans le container via AJAX
foreach ($messages as $msg):
    $classe = ($msg['expediteur_id'] == $mon_id) ? 'message-right' : 'message-left';
    echo "<div class='$classe'>";

    if ($msg['type'] === 'texte') {
        echo nl2br(htmlspecialchars($msg['contenu']));
    } elseif ($msg['type'] === 'image') {
        echo "<img src='" . htmlspecialchars($msg['fichier']) . "' style='max-width:100%; border-radius:10px;'>";
    } elseif ($msg['type'] === 'video') {
        echo "<video controls width='200'>
                <source src='" . htmlspecialchars($msg['fichier']) . "' type='video/mp4'>
              </video>";
    }

    echo "</div>";
endforeach;
