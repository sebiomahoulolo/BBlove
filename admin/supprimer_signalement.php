<?php
// Connexion PDO $pdo
$id_signalement = $_GET['id'] ?? null;
if (!$id_signalement) {
    die("ID signalement manquant.");
}

// Récupérer le signalement pour connaître l'utilisateur ciblé
$sql = "SELECT cible_id FROM signalements WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_signalement]);
$signalement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$signalement) {
    die("Signalement introuvable.");
}

$cible_id = $signalement['cible_id'];

// Supprimer ou marquer le signalement comme traité
// Exemple : suppression
$sql = "DELETE FROM signalements WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_signalement]);

// Compter le nombre de signalements en cours (non traités) pour cette cible
$sql = "SELECT COUNT(*) FROM signalements WHERE cible_id = :cible_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':cible_id' => $cible_id]);
$nb_signalements = $stmt->fetchColumn();

// Bloquer automatiquement si >= 3 signalements
if ($nb_signalements >= 3) {
    $sql = "UPDATE utilisateurs SET bloque = 1 WHERE id = :cible_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':cible_id' => $cible_id]);
    // Eventuellement enregistrer une action dans un journal
}

// Redirection après traitement
header("Location: ../admin_dashboard.php?page=signalements");
exit;
?>
