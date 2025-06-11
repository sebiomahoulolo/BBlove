<?php
    include '../db.php';


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $pdo->prepare("SELECT * FROM blog_articles WHERE id = ?");
  $stmt->execute([$id]);
  $article = $stmt->fetch();

  if ($article):
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove – Laissez votre cœur matcher au bon endroit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
      <style>
    .btn-retour {
      padding: 10px 20px;
      font-size: 16px;
      margin-bottom: 20px;
      display: inline-block;
      background-color: #b42040;
      color: white;
      border-radius: 8px;
      text-align: center;
      text-decoration: none;
    }

    img.img-fluid {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }

    h1 {
      font-size: 1.8rem;
      word-break: break-word;
    }

    p {
      font-size: 1rem;
      line-height: 1.6;
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 1.5rem;
      }

      .btn-retour {
        font-size: 14px;
        padding: 8px 16px;
        margin: 10px 0;
      }

      .container {
        padding: 0 15px;
      }
    }
  </style>
</head>
<body>
  
<div class="container my-5">
  <a href="../blog.php" class="btn-retour">&larr; Retour</a>

  <h1 class="text-danger"><?= htmlspecialchars($article['titre']) ?></h1>
  <p><strong><?= date('d/m/Y', strtotime($article['date_publication'])) ?> - <?= htmlspecialchars($article['categorie']) ?></strong></p>

  <?php if (!empty($article['image'])): ?>
    <img src="../uploads/<?= htmlspecialchars($article['image']) ?>" class="img-fluid mb-4" alt="Image de l'article">
  <?php endif; ?>

  <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
</div>

<?php
  else:
    echo "<p>Article introuvable.</p>";
  endif;
}
?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
