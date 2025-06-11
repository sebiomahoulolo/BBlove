<?php
include '../db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID manquant.";
    exit;
}

// Mise à jour de la demande comme refusée
$stmt = $pdo->prepare("UPDATE search_coach SET statut = 'refusée' WHERE id = ?");
$stmt->execute([$id]);

header("Location: ../coach_dashboard.php?page=demandes&refused=1");
exit;
