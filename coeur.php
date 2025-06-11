<?php include 'navbar.php'; ?>

<?php
include'db.php';

$now = date('Y-m-d H:i:s');
$media = $pdo->prepare("SELECT * FROM coeurs_brises_media WHERE expire_le > ?");
$media->execute([$now]);

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    /* Fond général */
body {
    background-color: #fff9f9;
    font-family: 'Segoe UI', sans-serif;
    color: #333;
}

.hero-coeurs-brises {
    background-image: url('images/coeur.jpg'); /* Remplace par ton chemin d'image */
    background-size: cover;
    background-position: center;
    height: 600px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.hero-coeurs-brises .overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Fond noir transparent */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 60px 30px;
    border-radius: 12px;
    animation: fadeIn 1.5s ease-in-out;
}


.hero-coeurs-brises h1 {
    font-size: 3rem;
    margin-bottom: 10px;
    font-weight: bold;
}

.hero-coeurs-brises p {
    font-size: 1.5rem;
    font-style: italic;
    color: #f1f1f1;
    font-weight: bold;
    text-align: center;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animation fadeInUp */
@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    h1 {
        font-size: 2rem;
    }
    .lead {
        font-size: 1rem;
    }
}

/* Section Coach */
.coach-section {
    padding: 40px 30px;
    text-align: center;
    border-top: 2px solid #ffccd5;
}
.coach-section img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 20px;
}
.coach-section .btn {
    background-color: #ff5a5f;
    color: white;
    padding: 10px 30px;
    border-radius: 30px;
    font-size: 1.1rem;
    transition: background-color 0.3s ease;
}
.coach-section .btn:hover {
    background-color: #e04045;
}
.coach-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}


/* Section Témoignages */
.temoignages {
    background: #fff;
    text-align: center;
    padding: 30px 10px;
}
.temoignages-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}
.temoignage-item {
    background: #fef2f2;
    padding: 10px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    width: 300px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.temoignage-item:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.temoignage-item img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 10px;
}

</style>

<body style="background-color: #fefefe; font-family: 'Segoe UI', sans-serif;">
     
    <!-- Titre principal avec image de fond -->
<div class="hero-coeurs-brises text-center text-white py-5">
  <div class="overlay px-3">
    <h1 class="fs-3 mb-3">💔 Cœurs Brisés</h1>
    <p class="fs-6 mb-2">
      Quand l'amour s'effondre, il est temps de se reconstruire... Pas à pas.
    </p>
    <p class="fs-6 mb-2">
      💔 <strong>Cœur Brisé</strong><br>
      Un espace d’écoute pour ceux qui souffrent en amour. <br>
      Nos coachs en thérapie de couple et conseil amoureux sont là pour vous aider à guérir, comprendre et avancer.
    </p>
    <p class="fs-6 mb-4">
      📩 <em>Contactez nos coachs dès maintenant pour un accompagnement personnalisé.</em>
    </p>
    <a href="coach/rdv_coaching.php" class="btn-custom">Contacter un coach</a>
  </div>
</div>


<!-- Section Coach -->
<section class="coach-section d-flex align-items-center py-4" style="gap: 1rem;">
  <div class="coach-image w-50">
    <img src="images/coach.avif" alt="Coach love" style="width: 300px; border-radius: 10px;">
  </div>
  <div class="coach-content w-50">
    <h2 class="text-danger mb-3">🤝 Rencontrez un coach </h2>
    <p class="mb-3 text-muted" style="text-align: justify;">
      <!-- Nos coachs vous écoutent, vous guident et vous aident à retrouver confiance. Grâce à leur expertise en relations 
      amoureuses, ils vous accompagnent pas à pas pour mieux comprendre vos besoins affectifs, surmonter vos blocages 
      émotionnels et construire des relations sincères et épanouissantes.--> Que vous traversiez une rupture difficile ou  
      cherchiez à rencontrer la bonne personne, nos coachs sont là pour vous apporter un soutien bienveillant, des 
      conseils personnalisés et des solutions concrètes.
    </p>
    <a href="coach/rdv_coaching.php" class="btn btn-primary mb-2">📅 Réserver une séance</a>
    <p class="text-muted">Séance gratuite ou payante selon disponibilité</p>
  </div>
</section>
<style>
  .coach-section {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding: 40px 20px;
}

.coach-section .coach-image,
.coach-section .coach-content {
  flex: 1 1 300px;
}

</style>

<section class="temoignages">
    <h2 style="color: #ff5a5f; font-size: 2rem;">💬 Témoignages de guérison</h2>

    <div class="temoignages-container">
        <div class="temoignage-item">
            <img src="images/avatars1.avif" alt="Témoin">
            <p><strong>Anna, 32 ans</strong></p>
            <p>"Grâce aux conseils de mon coach, j’ai retrouvé confiance en moi et ouvert un nouveau chapitre de ma vie. Merci BBLove ❤️"</p>
        </div>

        <div class="temoignage-item">
            <img src="images/avatars2.avif" alt="Témoin">
            <p><strong>Sylvain, 29 ans</strong></p>
            <p>"Je pensais que tout était fini après ma rupture. Mais j’ai trouvé du soutien ici, et j’avance enfin."</p>
        </div>

        <div class="temoignage-item">
            <img src="images/avatars3.avif" alt="Témoin">
            <p><strong>Camille, 26 ans</strong></p>
            <p>"Une écoute bienveillante, des conseils puissants. Aujourd’hui, je me sens transformée."</p>
        </div>

        <div class="temoignage-item">
            <img src="images/avatars4.avif" alt="Témoin">
            <p><strong>David, 35 ans</strong></p>
            <p>"BBLove m’a redonné foi en l’amour et en moi-même. Une expérience unique."</p>
        </div>

        <div class="temoignage-item">
            <img src="images/avatars5.avif" alt="Témoin">
            <p><strong>Sabrina, 30 ans</strong></p>
            <p>"Les séances m’ont aidée à guérir mes blessures intérieures. Je recommande à 100%."</p>
        </div>

        <div class="temoignage-item">
            <img src="images/avatars6.avif" alt="Témoin">
            <p><strong>Jean-Luc, 40 ans</strong></p>
            <p>"Je me sens renaître. Merci pour ce magnifique accompagnement vers la paix intérieure."</p>
        </div>
    </div>
</section> 

<div style="text-align: center;">
  <a href="coach/rdv_coaching.php" class="btn-custom">Contacter un coach</a>
</div>


<section class="coachs-section py-5">
  <h2 class="text-danger text-center mb-4">🌟 Nos coachs à votre écoute</h2>
  <p class="text-center text-muted mb-5">Des professionnels passionnés, prêts à vous accompagner vers l’épanouissement amoureux.</p>

  <div class="coachs-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
    <!-- Coach 1 -->
    <div class="coach-card" style="width: 180px; text-align: center; background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
      <img src="images/avatars1.avif" alt="Coach Anna" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
      <h5>Anna</h5>
      <p style="font-size: 0.9rem; color: #666;">Spécialiste en relations affectives</p>
    </div>

    <!-- Coach 2 -->
    <div class="coach-card" style="width: 180px; text-align: center; background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
      <img src="images/avatars2.avif" alt="Coach Sylvain" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
      <h5>Sylvain</h5>
      <p style="font-size: 0.9rem; color: #666;">Coach en reconstruction après rupture</p>
    </div>

    <!-- Coach 3 -->
    <div class="coach-card" style="width: 180px; text-align: center; background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
      <img src="images/avatars3.avif" alt="Coach Camille" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
      <h5>Camille</h5>
      <p style="font-size: 0.9rem; color: #666;">Thérapeute émotionnelle</p>
    </div>

    <!-- Coach 4 -->
    <div class="coach-card" style="width: 180px; text-align: center; background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
      <img src="images/avatars4.avif" alt="Coach David" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
      <h5>David</h5>
      <p style="font-size: 0.9rem; color: #666;">Coach confiance & estime de soi</p>
    </div>

    <!-- Coach 5 -->
    <div class="coach-card" style="width: 180px; text-align: center; background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
      <img src="images/avatars5.avif" alt="Coach Sabrina" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
      <h5>Sabrina</h5>
      <p style="font-size: 0.9rem; color: #666;">Coach pour femmes célibataires</p>
    </div>

    <!-- Coach 6 -->
    <div class="coach-card" style="width: 180px; text-align: center; background: #fff; border-radius: 12px; padding: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
      <img src="images/avatars6.avif" alt="Coach Jean-Luc" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
      <h5>Jean-Luc</h5>
      <p style="font-size: 0.9rem; color: #666;">Conseiller en relations durables</p>
    </div>
  </div>
</section>

<div style="text-align: center;">
  <a href="coach/rdv_coaching.php" class="btn-custom">Contacter un coach</a>
</div>


<?php
include'db.php';
$sql = "SELECT * FROM contenus ORDER BY date_publication DESC";
$stmt = $pdo->query($sql);
$contenus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <h2 class="text-center text-danger mb-4">📚 Des contenus pour vous</h2>

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($contenus as $contenu): ?>
      <div class="col">
        <div class="card h-100 shadow-sm">

          <!-- Image -->
          <?php if (!empty($contenu['image_url'])): ?>
            <img src="<?= htmlspecialchars($contenu['image_url']) ?>" class="card-img-top" alt="Illustration" style="height: 200px; object-fit: cover;">
          <?php endif; ?>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title text-danger"><?= htmlspecialchars($contenu['titre']) ?></h5>
            <p class="text-muted mb-1"><i><?= ucfirst($contenu['type']) ?></i></p>
            <p class="card-text small"><?= nl2br(htmlspecialchars(substr($contenu['description'], 0, 100))) ?>...</p>

            <div class="mt-auto">
              <?php if ($contenu['type'] === 'video' && $contenu['fichier_url']): ?>
                <video width="100%" height="200" controls class="mb-2">
                  <source src="<?= htmlspecialchars($contenu['fichier_url']) ?>" type="video/mp4">
                  Votre navigateur ne supporte pas la vidéo.
                </video>
                <a href="<?= htmlspecialchars($contenu['fichier_url']) ?>" class="btn btn-outline-primary w-100" target="_blank">🎬 Ouvrir la vidéo</a>

              <?php elseif ($contenu['type'] === 'seance' && $contenu['fichier_url']): ?>
                <a href="voir_contenu.php?id=<?= $contenu['id'] ?>" class="btn btn-outline-success w-100">📘 Voir la séance</a>

              <?php elseif ($contenu['type'] === 'article'): ?>
                <a href="voir_contenu.php?id=<?= $contenu['id'] ?>" class="btn btn-outline-danger w-100">📰 Lire l’article</a>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<br><b></b>



<div style="text-align: center;">
  <a href="coach/rdv_coaching.php" class="btn-custom">Contacter un coach</a>
</div>




<section class="py-5">
  <div class="container">
    <h2 class="text-danger text-center mb-4">🧘 Séances & Ateliers pour les cœurs brisés</h2>
    <div class="row g-4">
      <?php
        include 'db.php';
        $seances = $pdo->query("SELECT * FROM coeur_brise_seance ORDER BY date_event DESC")->fetchAll();

        if (count($seances) === 0) {
          echo "<p class='text-center'>Aucune séance disponible pour le moment.</p>";
        }

        foreach ($seances as $s):
      ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <?php if (!empty($s['image'])): ?>
            <img src="coach_actions/uploads/<?= htmlspecialchars($s['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title text-danger"><?= htmlspecialchars($s['titre']) ?></h5>
            <p class="card-text"><?= nl2br(htmlspecialchars($s['description'])) ?></p>
            <p><i class="bi bi-calendar-event"></i> <?= date('d/m/Y', strtotime($s['date_event'])) ?> à <?= $s['heure'] ?></p>
            <?php if (!empty($s['lieu'])): ?>
              <p><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($s['lieu']) ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>



<div style="text-align: center;">
  <a href="coach/search_coach.php" class="btn-custom">Contacter un coach</a>
</div>




<?php
include 'db.php';
$media = $pdo->query("SELECT * FROM coeurs_brises_media WHERE expire_le >= CURDATE() ORDER BY date_ajout DESC")->fetchAll();
?>
<section class="py-5" style="background-color: #fff9fa;">
  <div class="container">
    <h2 class="text-center text-danger mb-4">❤️ Podcast</h2>

    <?php if (count($media) === 0): ?>
      <div class="alert alert-info text-center">Aucun contenu disponible pour le moment.</div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($media as $m): ?>
          <div class="col-md-6">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <h5 class="card-title text-danger"><?= htmlspecialchars($m['titre']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($m['type'] === 'audio' ? '🎧 Audio' : '🎬 Vidéo') ?> — publié le <?= date('d/m/Y', strtotime($m['date_ajout'])) ?></p>
                <!--p ><?= htmlspecialchars($m['description']) ?></p-->

                <?php if ($m['type'] === 'video'): ?>
                  <video controls class="w-100" style="max-height: 300px;">
                    <source src="<?= htmlspecialchars($m['fichier']) ?>" type="video/mp4">
                    Votre navigateur ne prend pas en charge la vidéo.
                  </video>
                <?php else: ?>
                  <audio controls class="w-100 mt-2">
                    <source src="<?= htmlspecialchars($m['fichier']) ?>" type="audio/mpeg">
                    Votre navigateur ne prend pas en charge l'audio.
                  </audio>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>




</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'foooter.php'; ?>

