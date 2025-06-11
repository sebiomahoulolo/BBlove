<?php
include '../db.php';

$id = $_GET['id'] ?? null;

if ($id) {
  // On met à jour le statut
  $stmt = $pdo->prepare("UPDATE commandes_surprise SET statut = 'validé' WHERE id = ?");
  $stmt->execute([$id]);

  // Redirection
  header("Location: ../admin_dashboard.php?page=commandes_surprise");
  exit;
}
