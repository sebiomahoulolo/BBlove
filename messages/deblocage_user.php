<?php
session_start();
include '../db.php';

$bloqueur_id = $_SESSION['user_id'];
$bloque_id = $_GET['bloque_id'] ?? null;

if ($bloque_id && $bloque_id != $bloqueur_id) {
  $stmt = $pdo->prepare("DELETE FROM blocages WHERE bloqueur_id = ? AND bloque_id = ?");
  $stmt->execute([$bloqueur_id, $bloque_id]);
}

header("Location: ../dashboard.php?page=messages&to=$bloque_id");
exit();
