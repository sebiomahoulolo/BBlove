<?php include 'navbar.php'; ?>

<section id="commande-surprise" class="commande-surprise py-5" style="background: #fff;">
  <div class="container">
    <div class="row align-items-center g-4">

      <!-- 📸 Image à gauche -->
      <div class="col-md-5">
        <img src="images/surprise_love.png" alt="Surprise pour l'être aimé" class="img-fluid rounded shadow">
      </div>

      <!-- 📝 Texte  à droite -->
      <div class="col-md-7">
        <p class="text-danger mb-3" style="font-size: 2rem;">🎁 Préparer une surprise pour votre bien-aimé(e)</p>
        <p class="text-muted mb-4" style="font-size: 1rem;">Fleurs, gâteaux, repas, cartes d’amour… Personnalisez et envoyez votre attention romantique où vous le souhaitez !</p>
        <div style="text-align: center; padding: 15px;">
            <a href="surprise/commande.php" class=" btn-custom">Faire une surprise</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5" >
  <div class="container">
    <h2 class="text-center text-danger mb-4">Notre galerie de surprises</h2>
    <div class="row g-4">
      <?php
      include'db.php';
        $galerie = $pdo->query("SELECT * FROM galerie_surprise ORDER BY date_ajout DESC LIMIT 8")->fetchAll();
        foreach ($galerie as $item):
      ?>
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title text-danger"><?= htmlspecialchars($item['titre']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
            <p class="fw-bold"><?= number_format($item['prix'], 0, ',', ' ') ?> FCFA</p>
            <a href="surprise/galerie_surprise.php?item=<?= $item['id'] ?>" class="btn btn-outline-danger btn-sm">Commander</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<style>
  .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }

  .card:hover {
    transform: translateY(-15px);
    box-shadow: 0 12px 24px rgba(255, 90, 95, 0.3); /* effet rouge doux */
  }

  .card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .card-body {
    padding-bottom: 1.5rem;
  }

  .btn-outline-danger {
    transition: all 0.3s ease;
  }

  .btn-outline-danger:hover {
    background-color: #ff5a5f;
    color: #fff;
    border-color: #ff5a5f;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'foooter.php'; ?>
