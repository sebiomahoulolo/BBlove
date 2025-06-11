<?php
include '../db.php';

$id_commande = $_GET['id'] ?? null;

if (!$id_commande) {
    echo "Commande introuvable.";
    exit;
}

// Récupérer la commande
$stmt = $pdo->prepare("SELECT * FROM commandes_surprise WHERE id = ?");
$stmt->execute([$id_commande]);
$commande = $stmt->fetch();

if (!$commande) {
    echo "Commande introuvable.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commande_id = $_POST['commande_id'];
    $prix = floatval($_POST['prix']);
    $remise = floatval($_POST['remise']);
    $escompte = floatval($_POST['escompte']);
    $tva = 18; // par défaut
    $livraison = floatval($_POST['livraison']);

    $net = $prix;
    $net -= ($net * $remise / 100);
    $net -= ($net * $escompte / 100);
    $net += ($net * $tva / 100);
    $net += $livraison;
    $montant_total = round($net);

    // Structure du devis (JSON stocké)
    $details = [
        "prix" => $prix,
        "remise" => $remise,
        "escompte" => $escompte,
        "tva" => $tva,
        "livraison" => $livraison,
        "montant_total" => $montant_total
    ];

    $stmt = $pdo->prepare("UPDATE commandes_surprise SET devis_envoye = 1, devis = ?, montant_total = ?, statut = 'envoyé' WHERE id = ?");
    $stmt->execute([json_encode($details), $montant_total, $commande_id]);

    header("Location: ../admin_dashboard.php?page=commandes");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Préparer un devis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .total-box {
      font-weight: bold;
      font-size: 1.2rem;
      color: #d00000;
    }
  </style>
</head>
<body class="container my-5">

  <h3 class="text-danger">Préparer un devis pour : <?= htmlspecialchars($commande['expediteur_nom']) ?></h3>

  <form method="post" id="devisForm">
    <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">

    <table class="table table-bordered mt-4">
      <tr><th>Type de surprise</th><td><?= $commande['type_surprise'] ?></td></tr>
      <tr><th>Message</th><td><?= nl2br(htmlspecialchars($commande['message'])) ?></td></tr>
      <tr><th>Date/Heure</th><td><?= $commande['date_livraison'] ?> à <?= $commande['heure_livraison'] ?></td></tr>
    </table>

    <h5 class="mt-4 text-danger">🔢 Calcul du devis</h5>

    <div class="row g-3">
      <div class="col-md-4">
        <label>Prix de la commande (F CFA)</label>
        <input type="number" name="prix" id="prix" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label>Remise (%)</label>
        <input type="number" name="remise" id="remise" class="form-control" value="0">
      </div>
      <div class="col-md-4">
        <label>Escompte (%)</label>
        <input type="number" name="escompte" id="escompte" class="form-control" value="0">
      </div>
      <div class="col-md-4">
        <label>TVA (18%)</label>
        <input type="number" name="tva" id="tva" class="form-control" value="18" readonly>
      </div>
      <div class="col-md-4">
        <label>Frais de livraison (F CFA)</label>
        <input type="number" name="livraison" id="livraison" class="form-control" required>
      </div>
    </div>

    <div class="mt-4 total-box">
      Montant net à payer : <span id="total">0</span> F CFA
    </div>

    <button type="submit" class="btn btn-success mt-4">✅ Valider et enregistrer le devis</button>
    <a href="../admin_dashboard.php?page=commandes" class="btn btn-secondary mt-4">Retour</a>
  </form>

  <script>
    function calculerTotal() {
      const prix = parseFloat(document.getElementById("prix").value) || 0;
      const remise = parseFloat(document.getElementById("remise").value) || 0;
      const escompte = parseFloat(document.getElementById("escompte").value) || 0;
      const livraison = parseFloat(document.getElementById("livraison").value) || 0;
      const tva = 18;

      let montant = prix;
      montant -= (montant * remise) / 100;
      montant -= (montant * escompte) / 100;
      montant += (montant * tva) / 100;
      montant += livraison;

      document.getElementById("total").textContent = Math.round(montant);
    }

    document.querySelectorAll("#devisForm input").forEach(input => {
      input.addEventListener("input", calculerTotal);
    });
  </script>
</body>
</html>
