<?php
include '../db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID de rendez-vous manquant.";
    exit;
}

// Vérifier si le RDV existe
$stmt = $pdo->prepare("SELECT * FROM coaching_rdv WHERE rdv_id = ?");
$stmt->execute([$id]);
$rdv = $stmt->fetch();

if (!$rdv) {
    echo "Rendez-vous introuvable.";
    exit;
}

// Mettre à jour le statut du RDV à "rejeté"
$update = $pdo->prepare("UPDATE coaching_rdv SET statut = 'rejeté' WHERE rdv_id = ?");
$update->execute([$id]);

// Rediriger vers le tableau de bord
header("Location: ../coach_dashboard.php");
exit;
?>
