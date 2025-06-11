<?php
include '../db.php';

// Récupérer la liste des pays depuis la base de données
$paysList = $pdo->query("SELECT * FROM pays ORDER BY nom")->fetchAll();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date = $_POST['date_event'];
    $lieu = $_POST['lieu'];
    $pays = $_POST['pays'];
    $payant = isset($_POST['payant']) ? 1 : 0;
    $montant = $payant ? (int)$_POST['montant'] : 0;
    $par = isset($_POST['par']) ? $_POST['par'] : '';

    // Upload de l'image
    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $nomImage = time() . '_' . basename($_FILES['image']['name']);
        $cheminImage = '../uploads/' . $nomImage;
        move_uploaded_file($_FILES['image']['tmp_name'], $cheminImage);
        $image = $nomImage;
    }

    $stmt = $pdo->prepare("INSERT INTO evenements_pays (pays, titre, description, lieu, date_event, image, payant, montant, par) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$pays, $titre, $description, $lieu, $date, $image, $payant, $montant, $par]);
    $message = "Événement ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ajouter un événement par pays</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f4f4;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      max-width: 800px;
    }
    .btn-retour {
      margin-bottom: 20px;
    }
    #montantSection {
      display: none;
    }
  </style>
</head>
<body class="bg-light">
<div class="container mt-5">
  <a href="../admin_dashboard.php" class="btn btn-secondary btn-retour">&larr; Retour au dashboard</a>
  <h2 class="text-center mb-4 text-danger">Ajouter un événement par pays</h2>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success text-center"><?= $message; ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm bg-white">
    <div class="mb-3">
      <label for="pays" class="form-label">Pays</label>
      <select name="pays" class="form-control" required>
        <option value="">-- Sélectionner un pays --</option>
        <?php foreach ($paysList as $p): ?>
          <option value="<?= htmlspecialchars($p['nom']) ?>"><?= htmlspecialchars($p['nom']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="titre" class="form-label">Titre de l'événement</label>
      <input type="text" class="form-control" name="titre" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="5" required></textarea>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="date_event" class="form-label">Date et heure</label>
        <input type="datetime-local" class="form-control" name="date_event" required>
      </div>
      <div class="col-md-6 mb-3">
        <label for="lieu" class="form-label">Lieu</label>
        <input type="text" class="form-control" name="lieu" required>
      </div>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input type="file" class="form-control" name="image" accept="image/*">
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="payant" id="payantCheckbox" onchange="toggleMontant()" value="1">
      <label class="form-check-label" for="payantCheckbox">
        Événement payant ?
      </label>
    </div>

    <div id="montantSection">
      <div class="mb-3">
        <label for="montant" class="form-label">Montant (en FCFA)</label>
        <input type="number" class="form-control" name="montant" min="0" step="100">
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="par" id="parCouple" value="par couple">
        <label class="form-check-label" for="parCouple">Par couple</label>
      </div>
      <div class="form-check form-check-inline mb-3">
        <input class="form-check-input" type="radio" name="par" id="parPersonne" value="par personne">
        <label class="form-check-label" for="parPersonne">Par personne</label>
      </div>
    </div>

    <button type="submit" class="btn btn-danger w-100">Ajouter l'événement</button>
  </form>
</div>

<script>
  function toggleMontant() {
    const checkbox = document.getElementById('payantCheckbox');
    const section = document.getElementById('montantSection');
    section.style.display = checkbox.checked ? 'block' : 'none';
  }
  window.onload = toggleMontant;
</script>

</body>
</html>
