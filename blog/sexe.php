<?php
include '../db.php';

$categorie = 'La sexualité';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titre = $_POST['titre'];
  $contenu = $_POST['contenu'];
  $date = date('Y-m-d');

  
  // Gestion de l’image
  $imageName = null;
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    move_uploaded_file($tmpName, "../uploads/" . $imageName);
  }

  $stmt = $pdo->prepare("INSERT INTO blog_articles (titre, contenu, categorie, image, date_publication) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$titre, $contenu, $categorie, $imageName, $date]);

  $message = "Article publié avec succès.";
}
?>

<?php include 'form_template.php'; ?>
