<?php
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Vérifier si l'utilisateur est déjà abonné
$stmt = $pdo->prepare("SELECT * FROM abonnements WHERE user_id = ? AND date_fin > NOW()");
$stmt->execute([$user_id]);
$abonnement_actif = $stmt->fetch();

?>

  <style>
    body {
      background-color: #f7f7f7;
    }
    .card-abonnement {
      transition: transform 0.3s ease;
    }
    .card-abonnement:hover {
      transform: scale(1.05);
    }
    .btn-pay {
      background-color: #ff5a5f;
      color: white;
    }
    .btn-pay:hover {
      background-color: #e14d52;
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <h2 class="text-center text-primary mb-4">Choisissez votre abonnement</h2>

    <?php if ($abonnement_actif): ?>
      <div class="alert alert-success text-center">
        Vous êtes déjà abonné jusqu'au <strong><?= date('d/m/Y', strtotime($abonnement_actif['date_fin'])) ?></strong>.
      </div>
    <?php endif; ?>

    <div class="row g-4">
      <!-- Abonnement 2 semaines -->
      <div class="col-md-3">
        <div class="card card-abonnement shadow text-center p-3">
          <h5>2 semaines</h5>
          <p>1000 FCFA</p>
          <form method="POST" action="https://me.fedapay.com/bblove-boost-one">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <button type="submit" class="btn btn-pay w-100">S’abonner</button>
          </form>
        </div>
      </div>

      <!-- Abonnement 1 mois -->
      <div class="col-md-3">
        <div class="card card-abonnement shadow text-center p-3">
          <h5>1 mois</h5>
          <p>2000 FCFA</p>
          <form method="POST" action="https://me.fedapay.com/bblove-boost-two">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <button type="submit" class="btn btn-pay w-100">S’abonner</button>
          </form>
        </div>
      </div>

      <!-- Abonnement 3 mois -->
      <div class="col-md-3">
        <div class="card card-abonnement shadow text-center p-3">
          <h5>3 mois</h5>
          <p>5000 FCFA</p>
          <form method="POST" action="https://me.fedapay.com/bblove-boost-free">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <button type="submit" class="btn btn-pay w-100">S’abonner</button>
          </form>
        </div>
      </div>

      <!-- Abonnement 1 an -->
      <div class="col-md-3">
        <div class="card card-abonnement shadow text-center p-3">
          <h5>1 an</h5>
          <p>10 000 FCFA</p>
          <form method="POST" action="https://me.fedapay.com/bblove-boost-gold">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <button type="submit" class="btn btn-pay w-100">S’abonner</button>
          </form>
        </div>
      </div>
    </div>

  </div>

</body>
