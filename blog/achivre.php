<?php
include '../db.php';

if (isset($_GET['categorie'])) {
  $categorie = $_GET['categorie'];

  $stmt = $pdo->prepare("
    SELECT * FROM blog_articles
    WHERE categorie = ? AND date_publication <= DATE_SUB(NOW(), INTERVAL 7 DAY)
    ORDER BY date_publication DESC
  ");
  $stmt->execute([$categorie]);
  $articles = $stmt->fetchAll();
} else {
  // Redirection si aucune catégorie n'est fournie
  header("Location: ../blog.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Archive - <?= htmlspecialchars($categorie) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <h2 style="color: #ff5a5f;">Archives : <?= htmlspecialchars($categorie) ?></h2>

    <?php if ($articles): ?>
      <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <?php foreach ($articles as $article): ?>
          <div class="col">
            <div class="card h-100 shadow-sm">
              <?php if (!empty($article['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($article['image']) ?>" class="card-img-top" alt="image article">
              <?php endif; ?>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title" style="color:#ff5a5f;"><?= htmlspecialchars($article['titre']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 150))) ?>...</p>
                <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-outline-danger mt-auto">Lire plus</a>
              </div>
              <div class="card-footer text-muted">
                <?= date('d/m/Y', strtotime($article['date_publication'])) ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-muted mt-4">Aucun article archivé trouvé dans cette catégorie.</p>
    <?php endif; ?>
  </div>
</body>
</html>
