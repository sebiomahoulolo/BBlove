<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coach') {
  header("Location: ../login.php");
  exit();
}

$coach_id = $_SESSION['user_id'];
$titre = $_POST['titre'];
$description = $_POST['description'];
$date = $_POST['date_event'];
$heure = $_POST['heure'];
$lieu = $_POST['lieu'] ?? '';
$image = '';

// Upload image si disponible
if (!empty($_FILES['image']['name'])) {
  $nomImage = time() . '_' . basename($_FILES['image']['name']);
  $chemin = 'uploads/' . $nomImage;
  move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
  $image = $nomImage;
}

// Insertion dans coeur_brise_seance
$stmt = $pdo->prepare("INSERT INTO coeur_brise_seance (titre, description, date_event, heure, lieu, image, coach_id)
VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$titre, $description, $date, $heure, $lieu, $image, $coach_id]);

header("Location: ../coach_dashboard.php");
exit();
?>
