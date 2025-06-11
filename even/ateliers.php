<?php
include '../db.php';

// Récupération des ateliers uniquement
$ateliers = $pdo->query("SELECT * FROM evenements WHERE type = 'atelier' ORDER BY date_event DESC")->fetchAll();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Important -->
  <title>Nos Ateliers - Séance sur BBLove</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
    }
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      padding: 1rem;
    }
    @media (min-width: 768px) {
      .grid-container {
        padding: 2rem 3rem;
      }
    }
    .card-event {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .card-event:hover {
      transform: translateY(-5px);
    }
    .card-event img {
      width: 100%;
      height: auto;
      max-height: 200px;
      object-fit: cover;
    }
    .card-body {
      padding: 20px;
    }
    .card-body h5 {
      color: #ff5a5f;
      font-weight: bold;
    }
    .card-body p {
      font-size: 15px;
    }
    .badge-payant {
      background: #ff5a5f;
      color: white;
      font-size: 13px;
      padding: 5px 10px;
      border-radius: 8px;
    }
    .badge-gratuit {
      background: #28a745;
      color: white;
      font-size: 13px;
      padding: 5px 10px;
      border-radius: 8px;
    }
  </style>
</head>

<body>

<div class="container-fluid">
<button class="btn"><a href="../even.php" style="text-decoration: none; color: #ff5a5f;">Retour</a></button>

  <h2 class="text-center my-4" style="color: #ff5a5f;">Nos Ateliers & Coachings</h2>

  <div class="grid-container">
    <?php foreach ($ateliers as $atelier): ?>
      <div class="card-event">
        <?php if (!empty($atelier['image'])): ?>
          <img src="../uploads/<?php echo htmlspecialchars($atelier['image']); ?>" alt="<?php echo htmlspecialchars($atelier['titre']); ?>">
        <?php else: ?>
          <img src="images/atelier_default.jpg" alt="Image par défaut">
        <?php endif; ?>
        <div class="card-body">
          <h5><?php echo htmlspecialchars($atelier['titre']); ?></h5>
          <p><?php echo mb_strimwidth(strip_tags($atelier['description']), 0, 120, '...'); ?></p>
          <p><strong>🗓</strong> <?php echo date('d/m/Y', strtotime($atelier['date_event'])); ?></p>
          <p><strong>🗓</strong> <?php echo date('H:i', strtotime($atelier['date_event'])); ?></p>
          <p><strong>📍</strong> <?php echo htmlspecialchars($atelier['lieu']); ?></p>

          <?php if ($atelier['payant']): ?>
            <span class="badge-payant">Payant - <?php echo number_format($atelier['montant'], 0, ',', ' '); ?> FCFA <small>(par personne)</small></span>
          <?php else: ?>
            <span class="badge-gratuit">Gratuit</span>
          <?php endif; ?>

          <div class="mt-3">
            <a href="inscription_soiree.php?id=<?php echo $atelier['id']; ?>" class="btn btn-sm btn-danger">S'inscrire</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>
