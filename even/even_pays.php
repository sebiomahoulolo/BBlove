<?php
include '../db.php';

// Récupérer le pays depuis l'URL
$pays = $_GET['pays'] ?? '';

// Récupérer les événements correspondant au pays
$stmt = $pdo->prepare("SELECT * FROM evenements_pays WHERE pays = ? ORDER BY date_event DESC");
$stmt->execute([$pays]);
$evenements = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Événements en <?= htmlspecialchars($pays) ?> - BBLove</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9f9f9;
    }
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      padding: 40px;
    }
    .card-event {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .card-event:hover {
      transform: translateY(-5px);
    }
    .card-event img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .card-body {
      padding: 20px;
    }
    .card-body h5 {
      color: #ff5a5f;
      font-weight: bold;
    }
    .badge-pays {
      background-color: #eee;
      color: #333;
      font-size: 13px;
      padding: 5px 10px;
      border-radius: 20px;
      margin-bottom: 10px;
      display: inline-block;
    }
    .badge-payant {
      background-color: #ff5a5f;
      color: white;
      font-size: 13px;
      padding: 5px 10px;
      border-radius: 8px;
    }
    .badge-gratuit {
      background-color: #28a745;
      color: white;
      font-size: 13px;
      padding: 5px 10px;
      border-radius: 8px;
    }
    .btn-inscription {
      background-color: #ff5a5f;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      margin-top: 10px;
      display: inline-block;
      text-decoration: none;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }
    .btn-inscription:hover {
      background-color: #e0484d;
    }


    /* Pour mobiles et petits écrans */
@media (max-width: 768px) {
  .grid-container {
    grid-template-columns: 1fr !important; /* 1 colonne sur mobile */
    padding: 20px; /* Moins de padding sur mobile */
    gap: 20px;
  }

  .card-event img {
    height: auto;       /* Laisser l’image adapter sa hauteur */
    max-height: 250px;  /* Limite max pour ne pas prendre trop de place */
  }

  .card-body {
    padding: 15px;
  }

  .btn-inscription {
    width: 100%;       /* Bouton plein largeur sur mobile */
    text-align: center;
    padding: 12px 0;
    font-size: 1rem;
  }

  .badge-pays, .badge-payant, .badge-gratuit {
    font-size: 12px;
    padding: 4px 8px;
  }

  h2.text-center {
    font-size: 1.5rem;
    padding: 0 10px;
  }

  /* Optionnel : réduire les marges sur les paragraphes */
  .card-body p {
    margin-bottom: 8px;
  }
}

  </style>
</head>
<body>
<div class="container">
<a href="../even.php" class="btn btn-secondary btn-retour">&larr; Retour</a>
  <h2 class="text-center my-4" style="color: #ff5a5f;">Événements en <?= htmlspecialchars($pays) ?></h2>
  
      <div class="grid-container">
      <?php if (count($evenements) === 0): ?>
        <p style="font-size: 1.2rem; color: #555; text-align: center; width: 100%;">
          Aucun événement disponible pour <?= htmlspecialchars($pays) ?>.
        </p>
      <?php else: ?>
        <?php foreach ($evenements as $event): ?>
          <div class="card-event">
            <!-- Ton contenu d'événement ici -->
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  <div class="grid-container">
    <?php foreach ($evenements as $event): ?>
      <div class="card-event">
        <?php if (!empty($event['image'])): ?>
          <img src="../uploads/<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['titre']); ?>">
        <?php else: ?>
          <img src="../images/default.jpg" alt="Image par défaut">
        <?php endif; ?>

        <div class="card-body">
          <span class="badge-pays"><?php echo htmlspecialchars($event['pays']); ?></span>
          <h5><?php echo htmlspecialchars($event['titre']); ?></h5>
          <p><?php echo mb_strimwidth(strip_tags($event['description']), 0, 120, '...'); ?></p>
          <p><strong>🗓</strong> <?php echo date('d/m/Y à H\hi', strtotime($event['date_event'])); ?></p>
          <p><strong>📍</strong> <?php echo htmlspecialchars($event['lieu']); ?></p>

          <?php if (!empty($event['payant']) && $event['payant']): ?>
            <p><span class="badge-payant">Payant - <?php echo number_format($event['montant'], 0, ',', ' '); ?> FCFA / <?php echo htmlspecialchars($event['par']); ?></span></p>
          <?php else: ?>
            <p><span class="badge-gratuit">Gratuit</span></p>
          <?php endif; ?>
          <a href="inscription_event.php?id=<?php echo $event['id']; ?>" class="btn-inscription">S'inscrire</a>

        </div>
        
      </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
