<?php
include '../db.php';

// Récupération de l'événement
$eventId = $_GET['id'] ?? null;
if (!$eventId) {
    die("ID de l'événement manquant.");
}

$stmt = $pdo->prepare("SELECT * FROM evenements_pays WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event) {
    die("Événement introuvable.");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO participants (nom, prenom, email, telephone, evenement_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $telephone, $eventId]);

    if (!empty($event['payant']) && $event['payant']) {
        header("Location: paiement.php?id=$eventId");
        exit();
    } else {
        $message = "Inscription réussie. Merci pour votre participation !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription - <?= htmlspecialchars($event['titre']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<a href="../even_pays.php" class="btn btn-secondary btn-retour">&larr; Retour</a>

  <h2 class="text-center text-danger">Inscription à l'événement : <?= htmlspecialchars($event['titre']) ?></h2>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success text-center mt-4"> <?= $message ?> </div>
  <?php endif; ?>

  <form method="POST" class="card p-4 mt-4 shadow-sm">
    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" name="nom" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="prenom" class="form-label">Prénom</label>
      <input type="text" name="prenom" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="telephone" class="form-label">Téléphone</label>
      <input type="text" name="telephone" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-danger w-100">Valider l'inscription</button>
  </form>
</div>
</body>
</html>
