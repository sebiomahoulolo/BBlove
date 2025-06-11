<?php
include 'db.php';
session_start();

if (!isset($_GET['id'])) {
    echo "Profil introuvable.";
    exit;
}

$user_id = $_GET['id'];

// Récupérer le profil
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur non trouvé.";
    exit;
}

// Récupérer la galerie
$media = $pdo->prepare("SELECT * FROM galerie WHERE user_id = ? ORDER BY id DESC");
$media->execute([$user_id]);
$galerie = $media->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Galerie de <?= htmlspecialchars($user['nom']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
  <h3 class="mb-4 text-danger">Galerie de <?= htmlspecialchars($user['nom']) ?></h3>

  <?php if (empty($galerie)): ?>
    <div class="alert alert-warning">Aucun média publié.</div>
  <?php endif; ?>

  <div class="row g-4">
    <?php foreach ($galerie as $media): ?>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <?php if ($media['type'] === 'photo'): ?>
            <img src="<?= $media['fichier'] ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
          <?php elseif ($media['type'] === 'video'): ?>
            <video controls style="width: 100%; height: auto;">
              <source src="<?= $media['fichier'] ?>" type="video/mp4">
              Votre navigateur ne supporte pas les vidéos.
            </video>
          <?php endif; ?>
          <div class="card-body">
            <p class="card-text"><?= nl2br(htmlspecialchars($media['legende'])) ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
</body>
</html>
