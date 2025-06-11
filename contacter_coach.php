<?php
include 'db.php';

$coach_id = $_GET['coach_id'] ?? null;
$demande_id = $_GET['demande_id'] ?? null;

if (!$coach_id || !$demande_id) {
    echo "<div class='alert alert-danger text-center'>Paramètres manquants.</div>";
    exit;
}

// Vérifier si une notification existe déjà
$check = $pdo->prepare("SELECT * FROM notifications_coach WHERE coach_id = ? AND demande_id = ?");
$check->execute([$coach_id, $demande_id]);

if ($check->rowCount() === 0) {
    // Enregistrer la notification
    $stmt = $pdo->prepare("INSERT INTO notifications_coach (coach_id, demande_id) VALUES (?, ?)");
    $stmt->execute([$coach_id, $demande_id]);
}
?>

<div style="padding: 60px; text-align: center; font-family: Arial;">
  <h2 style="color: #ff5a5f;">Votre demande a bien été envoyée</h2>
  <p>Un coach va vous contacter bientôt si votre demande est acceptée.</p>
  <a href="index.php" class="btn btn-danger mt-3">Retour à l’accueil</a>
</div>
