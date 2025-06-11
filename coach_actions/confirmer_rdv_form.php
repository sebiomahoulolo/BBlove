<?php
include '../db.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID manquant";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM coaching_rdv WHERE rdv_id = ?");
$stmt->execute([$id]);
$rdv = $stmt->fetch();

if (!$rdv) {
    echo "RDV introuvable";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation RDV</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- IMPORTANT pour mobiles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Pour limiter la largeur du formulaire sur grands écrans */
    form {
      max-width: 480px;
      margin: auto;
    }
    /* Un peu d'espace en haut sur petits écrans */
    body {
      padding-top: 1.5rem;
      padding-bottom: 1.5rem;
    }
  </style>
</head>
<body>

  <div class="container">
    <h4 class="mb-4 text-center">Confirmer le rendez-vous avec <?= htmlspecialchars($rdv['nom']) ?></h4>

    <form method="POST" action="traiter_confirmation_rdv.php" novalidate>

      <input type="hidden" name="id" value="<?= $rdv['rdv_id'] ?>">

      <div class="mb-3">
        <label for="date_rdv" class="form-label">Date du rendez-vous *</label>
        <input type="date" id="date_rdv" name="date_rdv" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="heure_rdv" class="form-label">Heure du rendez-vous *</label>
        <input type="time" id="heure_rdv" name="heure_rdv" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="mode" class="form-label">Type de rendez-vous *</label>
        <select id="mode" name="mode" class="form-select" required onchange="toggleLieuOuLien()">
          <option value="" selected disabled>-- Choisir --</option>
          <option value="en ligne">En ligne</option>
          <option value="présentiel">Présentiel</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="lien_ou_lieu" class="form-label" id="labelLieuOuLien">Lieu / Lien *</label>
        <input type="text" id="lien_ou_lieu" name="lien_ou_lieu" class="form-control" placeholder="Adresse ou lien de réunion" required>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="payantCheckbox" name="payant" onchange="toggleMontant()">
        <label class="form-check-label" for="payantCheckbox">Ce rendez-vous est payant</label>
      </div>

      <div class="mb-3" id="montantField" style="display:none;">
        <label for="montant" class="form-label">Montant à payer (FCFA)</label>
        <input type="number" id="montant" name="montant" class="form-control" min="0" step="100" placeholder="Exemple : 5000">
      </div>

      <button type="submit" class="btn btn-success w-100">✅ Confirmer le RDV</button>
      <a href="../coach_dashboard.php?page=rdv" class="btn btn-secondary w-100 mt-2">Retour</a>
    </form>
  </div>

  <script>
    function toggleMontant() {
      const payantCheckbox = document.getElementById('payantCheckbox');
      const montantField = document.getElementById('montantField');
      montantField.style.display = payantCheckbox.checked ? 'block' : 'none';
    }

    function toggleLieuOuLien() {
      const modeSelect = document.getElementById('mode');
      const label = document.getElementById('labelLieuOuLien');
      if(modeSelect.value === 'en ligne') {
        label.textContent = 'Lien de la réunion (ex : https://meet.jit.si/...) *';
        document.getElementById('lien_ou_lieu').placeholder = 'Exemple : https://meet.jit.si/monrendezvous';
      } else if(modeSelect.value === 'présentiel') {
        label.textContent = 'Adresse du lieu *';
        document.getElementById('lien_ou_lieu').placeholder = 'Exemple : 12 rue de la paix, Paris';
      } else {
        label.textContent = 'Lieu / Lien *';
        document.getElementById('lien_ou_lieu').placeholder = 'Adresse ou lien de réunion';
      }
    }
  </script>

</body>
</html>
