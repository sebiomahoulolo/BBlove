<?php
include '../db.php';

$item_id = $_GET['item'] ?? null;
$surprise = null;

if ($item_id) {
    $stmt = $pdo->prepare("SELECT * FROM galerie_surprise WHERE id = ?");
    $stmt->execute([$item_id]);
    $surprise = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Commander une surprise</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #fdf8f8;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-section {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    h2, h5 {
      color: #d90429;
    }

    label {
      font-weight: 500;
      color: #333;
    }

    textarea {
      resize: vertical;
    }

    .btn-danger {
      background-color: #d90429;
      border: none;
    }

    .btn-danger:hover {
      background-color: #a8021f;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="form-section">

    <h2 class="mb-4 text-center">🎁 Commander une surprise</h2>

    <?php if ($surprise): ?>
      <div class="alert alert-warning text-center">
        <strong>Surprise choisie :</strong> <?= htmlspecialchars($surprise['titre']) ?> —
        <strong><?= number_format($surprise['prix'], 0, ',', ' ') ?> FCFA</strong>
      </div>
    <?php endif; ?>

    <form action="traitement_commande.php" method="post">
      <input type="hidden" name="item_id" value="<?= $surprise['id'] ?? '' ?>">

      <h5 class="mb-3">👤 Vos informations</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nom">Nom complet *</label>
          <input type="text" name="expediteur_nom" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Email *</label>
          <input type="email" name="expediteur_email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Téléphone *</label>
          <input type="text" name="expediteur_tel" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Ville</label>
          <input type="text" name="expediteur_ville" class="form-control">
        </div>
      </div>

      <hr class="my-4">

      <h5 class="mb-3">🎯 Destinataire</h5>
      <div class="row g-3">
        <div class="col-md-6">
          <label>Nom complet *</label>
          <input type="text" name="destinataire_nom" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Email</label>
          <input type="email" name="destinataire_email" class="form-control">
        </div>
        <div class="col-md-6">
          <label>Téléphone *</label>
          <input type="text" name="destinataire_tel" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Ville ou adresse *</label>
          <input type="text" name="destinataire_ville" class="form-control" required>
        </div>
      </div>

      <hr class="my-4">

      <div class="mb-3">
        <label>Détails de la commande</label>
        <textarea name="details_commande" class="form-control" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <label>Votre message d’amour (facultatif)</label>
        <textarea name="message" class="form-control" rows="3"></textarea>
      </div>

      <hr class="my-4">

      <div class="row g-3">
        <div class="col-md-6">
          <label>Date de livraison *</label>
          <input type="date" name="date_livraison" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Heure de livraison *</label>
          <input type="time" name="heure_livraison" class="form-control" required>
        </div>
      </div>

      <div class="text-center mt-4">
        <button class="btn btn-danger px-5 py-2">✅ Envoyer la commande</button>
      </div>
    </form>

  </div>
</div>

</body>
</html>
