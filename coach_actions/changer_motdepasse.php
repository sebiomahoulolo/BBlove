<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
  $newPassword = password_hash($_POST['nouveau_mdp'], PASSWORD_DEFAULT);
  $id = $_SESSION['user_id'];

  $stmt = $pdo->prepare("UPDATE users SET mot_de_passe = ? WHERE id = ?");
  $stmt->execute([$newPassword, $id]);

  header("Location: ../coach_dashboard.php?page=parametres&msg=mdp_ok");
}
