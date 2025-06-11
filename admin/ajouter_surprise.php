<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titre = $_POST['titre'];
  $description = $_POST['description'];
  $prix = $_POST['prix'];

  // Upload image
  $image = $_FILES['image']['name'];
  $image_path = 'uploads/surprises/' . time() . '_' . basename($image);
  move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image_path);

  $stmt = $pdo->prepare("INSERT INTO galerie_surprise (titre, description, image, prix) VALUES (?, ?, ?, ?)");
  $stmt->execute([$titre, $description, $image_path, $prix]);

  header('Location: ../admin_dashboard.php?page=galerie_surprise');
  exit;
}
?>
