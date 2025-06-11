
<body>
    <div class="container mt-4">
    <h3 class="text-danger mb-4">🎞️ Ma galerie</h3>

    <?php
    include'db.php';
    $user_id = $_SESSION['user_id'];
    $galerie = $pdo->prepare("SELECT * FROM galerie WHERE user_id = ? ORDER BY id DESC");
    $galerie->execute([$user_id]);
    $medias = $galerie->fetchAll();
    ?>

    <div class="row g-3">
      <?php foreach ($medias as $media): ?>
        <div class="col-md-4">
          <div class="card shadow-sm">
            <?php if ($media['type'] === 'photo'): ?>
              <img src="<?= htmlspecialchars($media['fichier']) ?>" class="card-img-top" alt="photo" style="height: 250px; object-fit: cover;">
            <?php elseif ($media['type'] === 'video'): ?>
              <video controls width="100%" height="250">
                <source src="<?= htmlspecialchars($media['fichier']) ?>" type="video/mp4">
              </video>
            <?php endif; ?>
            <div class="card-body">
              <p class="card-text"><?= htmlspecialchars($media['legende']) ?></p>
              <small class="text-muted"><?= date('d/m/Y', strtotime($media['created_at'] ?? 'now')) ?></small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</body>
