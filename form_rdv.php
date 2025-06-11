<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'coach') {
  header("Location: ../login.php");
  exit();
}

$demande_id = $_GET['id'] ?? null;
if (!$demande_id) {
  echo "<div class='alert alert-danger'>Demande introuvable.</div>";
  exit;
}

// Récupérer les infos de la demande
$stmt = $pdo->prepare("SELECT * FROM search_coach WHERE id = ?");
$stmt->execute([$demande_id]);
$demande = $stmt->fetch();

if (!$demande) {
  echo "<div class='alert alert-danger'>Demande inexistante.</div>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Planifier un rendez-vous</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="text-danger mb-4">Planifier un rendez-vous avec <?= htmlspecialchars($demande['nom']) ?></h3>

  <form action="enregistrer_rdv.php" method="post" class="card p-4 shadow-sm">
    <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
    <input type="hidden" name="coach_id" value="<?= $_SESSION['user_id'] ?>">

    <div class="mb-3">
      <label for="date_rdv" class="form-label">Date du rendez-vous *</label>
      <input type="date" name="date_rdv" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="heure_rdv" class="form-label">Heure *</label>
      <input type="time" name="heure_rdv" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="lien_jitsi" class="form-label">Lien Jitsi (visioconférence) *</label>
      <input type="url" name="lien_jitsi" class="form-control" placeholder="https://meet.jit.si/monlien" required>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-success">✅ Confirmer le rendez-vous</button>
    </div>
  </form>
</div>

</body>
</html>
