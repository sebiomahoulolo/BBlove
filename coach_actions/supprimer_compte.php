<?php
session_start();
include '../db.php';

if (isset($_SESSION['user_id'])) {
  $id = $_SESSION['user_id'];

  $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);

  session_destroy();
  header("Location: ../../index.php");
}
