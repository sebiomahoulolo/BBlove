<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $coach_id = $_SESSION['user_id'];
  $utilisateur_id = $_POST['utilisateur_id'];
  $message = $_POST['message'];

  $stmt = $pdo->prepare("INSERT INTO messages_coach (coach_id, utilisateur_id, expediteur, message) VALUES (?, ?, 'coach', ?)");
  $stmt->execute([$coach_id, $utilisateur_id, $message]);

  header("Location: ../coach_dashboard.php?page=messagerie&id=$utilisateur_id");
  exit();
}
