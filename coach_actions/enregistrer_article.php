<?php
include '../db.php';

$titre     = $_POST['titre'];
$categorie = $_POST['categorie'];
$contenu   = $_POST['contenu'];
$image     = '';

// Gérer l’upload de l’image
if (!empty($_FILES['image']['name'])) {
  $nomImage = time() . '_' . basename($_FILES['image']['name']);
  $chemin   = '../uploads/' . $nomImage;
  move_uploaded_file($_FILES['image']['tmp_name'], $chemin);
  $image = $nomImage;
}

// Enregistrement dans la base
$stmt = $pdo->prepare("INSERT INTO blog_articles (titre, contenu, categorie, image, date_publication) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$titre, $contenu, $categorie, $image]);

header("Location: ../coach_dashboard.php");
exit();
?>
