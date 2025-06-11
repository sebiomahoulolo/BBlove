<?php
include '../db.php';

$admin_id = $_SESSION['user_id'];
$bloque_id = $_GET['bloque_id'] ?? null;

if ($bloque_id && $bloque_id != $admin_id) {
  // Évite les doublons
  $check = $pdo->prepare("SELECT * FROM blocages WHERE bloqueur_id = ? AND bloque_id = ?");
  $check->execute([$admin_id, $bloque_id]);

  if ($check->rowCount() == 0) {
    $stmt = $pdo->prepare("INSERT INTO blocages (bloqueur_id, bloque_id) VALUES (?, ?)");
    $stmt->execute([$admin_id, $bloque_id]);
  }
}

header('Location: ../admin_dashboard.php?page=signalements');
exit();
