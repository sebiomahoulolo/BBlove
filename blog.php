<?php
include 'db.php'; // ton fichier de connexion

// Récupération de la catégorie via l'URL
$categorie = $_GET['cat'] ?? null;

if ($categorie) {
  $stmt = $pdo->prepare("SELECT * FROM blog_articles WHERE categorie = ? ORDER BY date_publication DESC");
  $stmt->execute([$categorie]);
} else {
  $stmt = $pdo->query("SELECT * FROM blog_articles ORDER BY date_publication DESC");
}
$articles = $stmt->fetchAll();

// Regrouper les articles par catégorie
$groupesParCategorie = [];
foreach ($articles as $article) {
    $categorie = $article['categorie'];
    if (!isset($groupesParCategorie[$categorie])) {
        $groupesParCategorie[$categorie] = [];
    }
    $groupesParCategorie[$categorie][] = $article;
}


// Sélectionne les catégories avec au moins un article publié il y a plus de 7 jours
$stmt = $pdo->prepare("
  SELECT DISTINCT categorie
  FROM blog_articles
  WHERE date_publication <= DATE_SUB(NOW(), INTERVAL 7 DAY)
");
$stmt->execute();
$archives = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Récupérer toutes les catégories distinctes, triées alphabétiquement
$stmt = $pdo->prepare("SELECT DISTINCT categorie FROM blog_articles ORDER BY categorie ASC");
$stmt->execute();
$archives = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<?php include 'navbar.php'; ?>
<style>
 body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9;
}

.title-bar {
    background-color:rgb(253, 170, 170); /* Couleur de fond de la barre */
    padding: 20px 0; /* Espacement autour du texte */
}

.title-list {
    display: flex;
    justify-content: center; /* Centre les éléments horizontalement */
    list-style: none;
    padding: 0;
    margin: 0;
}

.title-item {
    margin-right: 30px; /* Espacement entre les titres */
}

.title-item:last-child {
    margin-right: 0; /* Enlève l'espacement à droite du dernier item */
}

.title-item a {
    text-decoration: none; /* Enlève le soulignement des liens */
    color: black; /* Couleur des titres */
    font-size: 18px; /* Taille du texte */
    font-weight: bold; /* Met en gras */
}

.title-item a:hover {
    color: #ff3e45; /* Changement de couleur au survol */
}

       
.header-banner {
    position: relative;
    background-image: url('images/image.avif');
    background-size: cover;
    background-position: center;
    height: 600px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-left: 40px;
    color: white;
    overflow: hidden;
}

.header-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.header-banner h2,
.header-banner p {
    position: relative;
    z-index: 2;
    opacity: 0;
    animation: fadeInUp 1.5s ease-out forwards;
}

.header-banner h2 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
    text-align: left;
    animation-delay: 0.2s;
    color: #fff;
}

.header-banner p:nth-of-type(1) {
    font-size: 1.1rem;
    margin-bottom: 5px;
    animation-delay: 0.4s;
    text-align: left;
    max-width: 600px;
}

/* Animation */
@keyframes fadeInUp {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.sidebar {
            background-color:rgb(236, 236, 251);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar h5 {
            color: #ff5a5f;
            font-weight: bold;
            font-size: 2rem;
        }
        .sidebar .list-group-item {
            background-color:rgb(236, 236, 251);
            border: none;
            padding: 10px 0;
            text-decoration: none;
            font-weight: bold;
        }

        .sidebar .list-group-item a {
            text-decoration: none;
            font-weight: bold;
            color:rgb(5, 5, 82);
        }

        .btn-view-more {
            background-color: #ff5a5f;
            color: white;
            border-radius: 5px;
        }
        .btn-view-more:hover {
            background-color: #ff3a3f;
        }

        .tag {
    display: inline-block;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 25px;
    padding: 8px 16px;
    font-size: 0.9rem;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tag:hover {
    background-color: #ff5a5f;
    color: #fff;
    border-color: #ff5a5f;
}
</style>

    <!-- Header -->
    <div class="header-banner">
        <h2><em style="color: #ff5a5f;">BBLove:</em> Conseils & Inspiration pour l'Amour Authentique</h2>
        <p>Des conseils pour mieux se comprendre, construire ensemble et vivre une histoire vraie. 
            Redécouvrez l’amour avec des mots simples, des gestes vrais..</p>

    </div>

    <div class="container my-5">
  <div class="row">
    <!-- Colonne des articles -->
    <div class="col-lg-8 pe-lg-5">
      <h2 class="text-center mb-5" style="color:#ff5a5f; font-weight:bold;">Nos Articles</h2>

      <?php foreach ($groupesParCategorie as $categorie => $articlesCategorie): ?>
        <div class="mb-5">
          <h1 class="mb-4" style="color: #ff5a5f;"><?= htmlspecialchars($categorie) ?></h1>
          <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php foreach ($articlesCategorie as $article): ?>
            <div class="col">
          <div class="card h-100 shadow-sm" style="height: 100%; max-height: 460px;">
            <?php if (!empty($article['image'])): ?>
              <img src="uploads/<?= htmlspecialchars($article['image']) ?>" class="card-img-top" alt="image article" style="height: 160px; object-fit: cover;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title" style="color: #ff5a5f; font-size: 1rem;">
                <?= htmlspecialchars($article['titre']) ?>
              </h5>
              <p class="card-text" style="font-size: 0.9rem;">
                <?= nl2br(htmlspecialchars(substr($article['contenu'], 0, 100))) ?>...
              </p>
              <a href="blog/article.php?id=<?= $article['id'] ?>" class="btn btn-outline-danger btn-sm mt-auto">Lire plus</a>
            </div>
            <div class="card-footer text-muted" style="font-size: 0.8rem;">
              <?= date('d/m/Y', strtotime($article['date_publication'])) ?>
            </div>
          </div>
        </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>


            <!-- Sidebar à droite -->
      <div class="col-lg-4">
        <div class="sidebar p-3 bg-light shadow-sm rounded">
          <h5 style="color:#ff5a5f;">Archives par catégorie</h5>
          <ul class="list-group list-group-flush">
            <?php foreach ($archives as $categorie): ?>
              <li class="list-group-item">
                <a href="blog/achivre.php?categorie=<?= urlencode($categorie) ?>">
                  <?= htmlspecialchars($categorie) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
  </div>
</div>

<section class="theme-tags py-5">
  <div class="container text-center">
    <h2 class="mb-4" style="font-weight: bold; color: #1e2a38;">Explorer des thèmes</h2>
    <div class="d-flex flex-wrap justify-content-center gap-2">
      <a href="blog.php?categorie=Conseils%20de%20rencontres" class="tag btn btn-outline-primary">Conseils de rencontres</a>
      <a href="blog.php?categorie=Rupture%20amoureuse" class="tag btn btn-outline-danger">Rupture amoureuse</a>
      <a href="blog.php?categorie=Vie%20de%20couple" class="tag btn btn-outline-success">Vie de couple</a>
      <a href="blog.php?categorie=Romantisme" class="tag btn btn-outline-warning">Romantisme</a>
      <a href="blog.php?categorie=Sexualité" class="tag btn btn-outline-dark">Sexualité</a>
    </div>
  </div>
</section>

<?php
include 'db.php';

// Articles de moins de 7 jours
$articles = $pdo->query("SELECT * FROM blog_articles WHERE date_publication >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY date_publication DESC")->fetchAll();

// Récupérer les catégories pour les archives
$archivesQuery = $pdo->query("SELECT DISTINCT categorie FROM blog_articles");
$archives = $archivesQuery->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="container mt-5">
  <div class="row">
    <!-- Articles -->
    <div class="col-lg-8">
      <h2 class="mb-4 text-danger">📝 Articles de nos coachs</h2>
      <?php if (count($articles) === 0): ?>
        <div class="alert alert-info">Aucun article récent pour le moment.</div>
      <?php endif; ?>

      <div class="row g-4">
        <?php foreach ($articles as $a): ?>
          <div class="col-md-6">
            <div class="card h-100 shadow-sm">
              <img src="uploads/<?= htmlspecialchars($a['image']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title text-danger"><?= htmlspecialchars($a['titre']) ?></h5>
                <p class="card-text small"><em>Catégorie : <?= htmlspecialchars($a['categorie']) ?></em></p>
                <p class="card-text"><?= substr(strip_tags($a['contenu']), 0, 100) ?>...</p>
                <p class="text-muted small">Publié par un coach le <?= date('d/m/Y', strtotime($a['date_publication'])) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  </body>
<?php include 'foooter.php'; ?>
