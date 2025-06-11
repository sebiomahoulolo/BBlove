<?php
include 'db.php';

// 1. Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirige vers la page de connexion
    header('Location: ../login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// 2. Vérifie que l'utilisateur existe bien en base
$stmt = $pdo->prepare("SELECT date_inscription FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    // L'utilisateur n'existe pas, redirige vers inscription
    session_destroy(); // Nettoie la session invalide
    header('Location: ../register.php');
    exit;
}

// 3. Calcul du nombre de jours depuis l'inscription
$dateInscription = new DateTime($user['date_inscription']);
$today = new DateTime();
$diff = $today->diff($dateInscription)->days;

// 4. Vérifie la validité de l’abonnement
$stmt2 = $pdo->prepare("SELECT date_fin FROM abonnements WHERE user_id = ?");
$stmt2->execute([$userId]);
$abonnement = $stmt2->fetch();

$abonnementValide = false;
if ($abonnement && new DateTime($abonnement['date_fin']) > $today) {
    $abonnementValide = true;
}

// 5. Autorisation ou redirection vers la page d’abonnement
if ($abonnementValide || $diff < 7) {
    // ✅ Accès autorisé
    return;
} else {
    // ❌ Abonnement expiré et période d’essai dépassée
    header('Location: ../abonnement.php');
    exit;
}
?>
