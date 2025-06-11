<?php
include '../db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date = $_POST['date_event'];
    $heure = $_POST['heure'];
    $lieu = $_POST['lieu'];
    $payant = isset($_POST['payant']) ? 1 : 0;
    $montant = $payant ? (int)$_POST['montant'] : 0;

   // Upload de l'image
   $image = "";
   if (!empty($_FILES['image']['name'])) {
       $nomImage = time() . '_' . basename($_FILES['image']['name']);
       $cheminImage = '../uploads/' . $nomImage;
       move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage);
       $image = $nomImage;
   }

    $stmt = $pdo->prepare("INSERT INTO evenements (titre, description, date_event, heure, lieu, image, payant, montant, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$titre, $description, $date, $heure, $lieu, $image, $payant, $montant, 'atelier']);
    $message = "Atelier ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un atelier - BBLove</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Responsiveness -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      max-width: 800px;
      margin: auto;
    }
    a {
      text-decoration: none;
    }
    .btn-retour {
      margin-bottom: 20px;
      color: #ff5a5f;
    }
    .btn-retour:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container py-4">
  <a href="../admin_dashboard.php" class="btn btn-link btn-retour">← Retour</a>

  <h2 class="text-center mb-4 text-danger">Ajouter un Atelier / Coaching</h2>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success text-center"><?= $message; ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label for="titre" class="form-label">Titre de l'atelier</label>
      <input type="text" class="form-control" name="titre" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="4" required></textarea>
    </div>

    <div class="row">
      <div class="col-md-6 col-12 mb-3">
        <label for="date_event" class="form-label">Date</label>
        <input type="date" class="form-control" name="date_event" required>
      </div>

      <div class="col-md-6 col-12 mb-3">
        <label for="heure" class="form-label">Heure</label>
        <input type="time" class="form-control" name="heure" required>
      </div>

      <div class="col-12 mb-3">
        <label for="lieu" class="form-label">Lieu</label>
        <input type="text" class="form-control" name="lieu" required>
      </div>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Image (optionnelle)</label>
      <input type="file" class="form-control" name="image" accept="image/*">
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="payant" id="payantCheckbox" onchange="toggleMontant()" value="1">
      <label class="form-check-label" for="payantCheckbox">
        Événement payant ?
      </label>
    </div>

    <div class="mb-3" id="montantField" style="display: none;">
      <label for="montant" class="form-label">Montant (en FCFA)</label>
      <input type="number" class="form-control" name="montant" id="montant" min="0" step="100">
    </div>

    <button type="submit" class="btn btn-danger w-100">Ajouter l'atelier</button>
  </form>
</div>

<script>
  function toggleMontant() {
    const checkbox = document.getElementById('payantCheckbox');
    const montantField = document.getElementById('montantField');
    montantField.style.display = checkbox.checked ? 'block' : 'none';
  }

  window.onload = toggleMontant;
</script>

</body>
</html>
