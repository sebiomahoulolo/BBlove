<?php
include '../db.php';

$eventId = $_GET['id'] ?? null;
if (!$eventId) {
    die("ID événement manquant.");
}

$stmt = $pdo->prepare("SELECT * FROM evenements_pays WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event || !$event['payant']) {
    die("Aucun paiement n'est requis pour cet événement.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Paiement - <?= htmlspecialchars($event['titre']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .payment-box {
      max-width: 500px;
      margin: auto;
      margin-top: 80px;
      padding: 30px;
      background: white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .btn-pay {
      background-color: #ff5a5f;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
      margin-top: 20px;
    }
  </style>
</head>
<body>
    <a href="../even_pays.php" class="btn btn-secondary btn-retour">&larr; Retour</a>
  <div class="payment-box text-center">
    <h3 class="text-danger">Paiement requis</h3>
    <p>Pour finaliser votre inscription à l'événement :</p>

    <h5 class="mb-3"> <?= htmlspecialchars($event['titre']) ?> </h5>
    <p><strong>Montant :</strong> <?= number_format($event['montant'], 0, ',', ' ') ?> FCFA / <?= htmlspecialchars($event['par']) ?></p>

    <p class="text-muted">Vous pouvez effectuer le paiement via FedaPay.</p>

    <a href="https://me.fedapay.com/bblove-surprise" class="btn btn-pay">Procéder au paiement</a>
  </div>
</body>
</html>
