<?php
include 'db.php';

$signalant_id = $_SESSION['user_id'];
$cible_id = $_GET['id'] ?? null;

if (!$cible_id || $cible_id == $signalant_id) {
    echo "<div class='alert alert-warning'>Signalement non autorisé.</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);

    $stmt = $pdo->prepare("INSERT INTO signalements (signalant_id, cible_id, type, message) VALUES (?, ?, 'profil', ?)");
    $stmt->execute([$signalant_id, $cible_id, $message]);

    echo "<div class='alert alert-success'>Le profil a été signalé. Merci pour votre vigilance.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Signaler un profil</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3 class="text-danger mb-4">🚨 Signaler ce profil</h3>
    <form method="POST">
      <div class="mb-3">
        <label for="message" class="form-label">Expliquez la raison du signalement :</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-danger">Envoyer le signalement</button>
      <a href="public_profil.php?id=<?= $cible_id ?>" class="btn btn-secondary ms-2">Annuler</a>
    </form>
  </div>
</body>
</html>
