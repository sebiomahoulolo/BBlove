<?php
session_start();
include '../db.php';

$bloqueur_id = $_SESSION['user_id'];
$bloque_id = $_GET['bloque_id'] ?? null;

if ($bloque_id && $bloque_id != $bloqueur_id) {
  $check = $pdo->prepare("SELECT * FROM blocages WHERE bloqueur_id = ? AND bloque_id = ?");
  $check->execute([$bloqueur_id, $bloque_id]);

  if ($check->rowCount() === 0) {
    $stmt = $pdo->prepare("INSERT INTO blocages (bloqueur_id, bloque_id) VALUES (?, ?)");
    $stmt->execute([$bloqueur_id, $bloque_id]);
  }
}

header("Location: ../dashboard.php?page=messages");
exit();
