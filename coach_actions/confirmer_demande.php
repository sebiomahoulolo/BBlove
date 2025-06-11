<?php
include '../db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID manquant.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM search_coach WHERE id = ?");
$stmt->execute([$id]);
$demande = $stmt->fetch();

if (!$demande) {
    echo "Demande introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation RDV</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

  <h4 class="text-danger mb-4">Confirmer la demande de coaching de <?= htmlspecialchars($demande['prenom_utilisateur'] . ' ' . $demande['nom_utilisateur']) ?></h4>

  <form method="POST" action="traiter_confirmation_rdv.php">
    <input type="hidden" name="id" value="<?= $rdv['id'] ?>">

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="payantCheckbox" name="payant" onchange="toggleMontant()">
      <label class="form-check-label" for="payantCheckbox">Ce rendez-vous est payant</label>
    </div>

    <div class="mb-3" id="montantField" style="display:none;">
      <label for="montant">Montant à payer (FCFA)</label>
      <input type="number" class="form-control" name="montant" min="0" step="100">
    </div>

    <button type="submit" class="btn btn-success">✅ Confirmer le RDV</button>
    <a href="../coach_dashboard.php?page=rdv" class="btn btn-secondary">Retour</a>
  </form>

  <script>
    function toggleMontant() {
      const isChecked = document.getElementById('payantCheckbox').checked;
      document.getElementById('montantField').style.display = isChecked ? 'block' : 'none';
    }
  </script>
</body>
</html>
