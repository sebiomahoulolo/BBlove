<?php
session_start();
include '../db.php';

// Authentification coach obligatoire
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'coach') {
  header("Location: ../login.php");
  exit();
}

$article_id = $_GET['id'] ?? null;
if (!$article_id) {
  echo "<div class='alert alert-danger'>Article introuvable.</div>";
  exit();
}

// Récupérer les données de l'article
$stmt = $pdo->prepare("SELECT * FROM blog_articles WHERE id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
  echo "<div class='alert alert-danger'>Article non trouvé.</div>";
  exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titre = $_POST['titre'];
  $contenu = $_POST['contenu'];
  $categorie = $_POST['categorie'];
  $image = $article['image'];

  // Upload image si une nouvelle est fournie
  if (!empty($_FILES['image']['name'])) {
    $nomImage = time() . '_' . basename($_FILES['image']['name']);
    $cheminImage = '../uploads/' . $nomImage;
    move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage);
    $image = $nomImage;
  }

  $stmt = $pdo->prepare("UPDATE blog_articles SET titre=?, contenu=?, categorie=?, image=? WHERE id=?");
  $stmt->execute([$titre, $contenu, $categorie, $image, $article_id]);

  echo "<script>alert('Article modifié avec succès'); window.location.href='../coach_dashboard.php?page=accueil';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un article</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h3 class="text-danger mb-4">Modifier l'article</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Titre</label>
      <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($article['titre']) ?>" required>
    </div>

    <div class="mb-3">
      <label>Contenu</label>
      <textarea name="contenu" rows="6" class="form-control" required><?= htmlspecialchars($article['contenu']) ?></textarea>
    </div>

    <div class="mb-3">
      <label>Catégorie</label>
      <select name="categorie" class="form-select" required>
        <option <?= $article['categorie'] === 'Conseils de rencontres' ? 'selected' : '' ?>>Conseils de rencontres</option>
        <option <?= $article['categorie'] === 'Vie de couple' ? 'selected' : '' ?>>Vie de couple</option>
        <option <?= $article['categorie'] === 'Rupture amoureuse' ? 'selected' : '' ?>>Rupture amoureuse</option>
        <option <?= $article['categorie'] === 'Sexualité' ? 'selected' : '' ?>>Sexualité</option>
        <option <?= $article['categorie'] === 'Romantisme' ? 'selected' : '' ?>>Romantisme</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Changer l'image (optionnel)</label>
      <input type="file" name="image" class="form-control">
      <?php if (!empty($article['image'])): ?>
        <img src="../uploads/<?= htmlspecialchars($article['image']) ?>" width="100" class="mt-2">
      <?php endif; ?>
    </div>

    <button class="btn btn-primary">💾 Enregistrer les modifications</button>
    <a href="../coach_dashboard.php?page=accueil" class="btn btn-secondary">Annuler</a>
  </form>
</body>
</html>
