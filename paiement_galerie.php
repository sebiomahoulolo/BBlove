<?php
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
  echo "<div class='alert alert-danger'>Commande introuvable.</div>";
  exit;
}

// Récupération de la commande
$stmt = $pdo->prepare("SELECT * FROM commandes_galerie WHERE id = ?");
$stmt->execute([$id]);
$commande = $stmt->fetch();

if (!$commande) {
  echo "<div class='alert alert-danger'>Commande non trouvée.</div>";
  exit;
}

// Si l'utilisateur simule qu'il a payé
if (isset($_GET['confirm']) && $_GET['confirm'] === '1') {
  $pdo->prepare("UPDATE commandes_galerie SET statut = 'validé' WHERE id = ?")->execute([$id]);

  echo "<div style='padding: 40px; text-align: center; font-family: sans-serif;'> 
    <h2 style='color: green;'>✅ Paiement confirmé</h2> 
    <p>Merci pour votre paiement. Nous vous contacterons dès que la commande est prête.</p>
    <a href='index.php' class='btn btn-success mt-3'>Retour à l’accueil</a>
  </div>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Paiement de la commande</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-5">

  <h2 class="text-center text-danger mb-4">💳 Paiement de votre commande</h2>

  <div class="alert alert-light text-center">
    <p><strong>Commande :</strong> <?= htmlspecialchars($commande['type_surprise']) ?></p>
    <p><strong>Nom :</strong> <?= htmlspecialchars($commande['expediteur_nom']) ?></p>
    <p><strong>Destinataire :</strong> <?= htmlspecialchars($commande['destinataire_nom']) ?></p>
    <p><strong>Date Livraison :</strong> <?= htmlspecialchars($commande['date_livraison']) ?> à <?= htmlspecialchars($commande['heure_livraison']) ?></p>
    <p class="text-danger fw-bold">Montant à payer : Selon votre sélection</p>
  </div>

  <div class="text-center">
    <a href="https://me.fedapay.com/bblove-surprise" target="_blank" class="btn btn-danger btn-lg">🔐 Payer maintenant</a>

    <hr class="my-4">

    <p>Après avoir effectué le paiement, cliquez ici :</p>
    <a href="?id=<?= $id ?>&confirm=1" class="btn btn-success">✅ J’ai déjà payé</a>
  </div>

</body>
</html>
