<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='alert alert-danger text-center mt-5'>❌ Contenu introuvable.</div>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM contenus WHERE id = ?");
$stmt->execute([$id]);
$contenu = $stmt->fetch();

if (!$contenu) {
    echo "<div class='alert alert-danger text-center mt-5'>❌ Contenu non trouvé.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($contenu['titre']) ?> - Contenu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
  <div class="card shadow">
    <?php if (!empty($contenu['image_url'])): ?>
      <img src="<?= htmlspecialchars($contenu['image_url']) ?>" class="card-img-top" alt="Illustration" style="max-height: 400px; object-fit: cover;">
    <?php endif; ?>

    <div class="card-body">
      <h2 class="card-title text-danger"><?= htmlspecialchars($contenu['titre']) ?></h2>
      <p class="text-muted">Publié le <?= date('d/m/Y', strtotime($contenu['date_publication'])) ?> | Type : <?= htmlspecialchars($contenu['type']) ?></p>
      <hr>

      <div class="mb-3">
        <?= nl2br(htmlspecialchars($contenu['description'])) ?>
      </div>

      <?php if ($contenu['type'] === 'video' && $contenu['fichier_url']): ?>
        <video width="100%" height="400" controls>
          <source src="<?= htmlspecialchars($contenu['fichier_url']) ?>" type="video/mp4">
          Votre navigateur ne supporte pas cette vidéo.
        </video>

      <?php elseif ($contenu['type'] === 'seance' && $contenu['fichier_url']): ?>
        <a href="<?= htmlspecialchars($contenu['fichier_url']) ?>" class="btn btn-outline-success mt-3" target="_blank">📄 Ouvrir le fichier de la séance</a>

      <?php elseif ($contenu['type'] === 'article'): ?>
        <div class="mt-4 p-3 bg-white border rounded shadow-sm">
          <?= nl2br(htmlspecialchars($contenu['description'])) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="text-center mt-4">
    <a href="coeur.php" class="btn btn-secondary">⬅️ Retour</a>
  </div>
</div>

</body>
</html>
