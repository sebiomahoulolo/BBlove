<?php
session_start();
include '../../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coach') {
  header("Location: ../../login.php");
  exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
  $stmt = $pdo->prepare("DELETE FROM coeur_brise_seance WHERE id = ? AND coach_id = ?");
  $stmt->execute([$id, $_SESSION['user_id']]);
}

header("Location: ../coach_dashboard.php?page=accueil");
exit();
?>
