<?php
include '../db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $ville = $_POST['ville'];
    $telephone = $_POST['telephone'];

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

   // Insertion dans la table even (à adapter si tu veux stocker nom, prénom etc. dans une autre table ou colonne)
 $stmt = $pdo->prepare("INSERT INTO even (nom, prenom, ville, telephone, titre, description, date_event, heure, lieu, image, payant, montant, type, statut) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'en_attente')");
    $stmt->execute([$nom, $prenom, $ville, $telephone, $titre, $description, $date, $heure, $lieu, $image, $payant, $montant, 'soiree']);
    $message = "Soiree ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Ajouté pour la responsivité -->
  <title>Ajouter une soirée - BBLove</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>


<body class="bg-light">
<div class="container mt-5">
  <button class="btn mb-3">
    <a href="../even.php" style="text-decoration: none; color: #ff5a5f;">Retour</a>
  </button>

  <h2 class="text-center mb-4 text-danger">Ajouter une Soirée pour Célibataires</h2>

  <?php if (!empty($message)): ?>
    <div class="alert alert-success text-center"><?= $message; ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" id="nom" required />
      </div>

      <div class="col-md-6 mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" name="prenom" id="prenom" required />
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" class="form-control" name="ville" id="ville" required />
      </div>

      <div class="col-md-6 mb-3">
        <label for="telephone" class="form-label">Téléphone</label>
        <input type="tel" class="form-control" name="telephone" id="telephone" pattern="[0-9]{8,15}" placeholder="Ex : 770000000" required />
      </div>
    </div>

    <div class="mb-3">
      <label for="titre" class="form-label">Titre de la soirée</label>
      <input type="text" class="form-control" name="titre" id="titre" required />
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="date_event" class="form-label">Date</label>
        <input type="date" class="form-control" name="date_event" id="date_event" required />
      </div>

      <div class="col-md-6 mb-3">
        <label for="heure" class="form-label">Heure</label>
        <input type="time" class="form-control" name="heure" id="heure" required />
      </div>

      <div class="col-12 mb-3">
        <label for="lieu" class="form-label">Lieu</label>
        <input type="text" class="form-control" name="lieu" id="lieu" required />
      </div>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Image (optionnelle)</label>
      <input type="file" class="form-control" name="image" id="image" accept="image/*" />
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="payant" id="payantCheckbox" onchange="toggleMontant()" value="1" />
      <label class="form-check-label" for="payantCheckbox">
        Événement payant ?
      </label>
    </div>

    <div class="mb-3" id="montantField" style="display: none;">
      <label for="montant" class="form-label">Montant (en FCFA)</label>
      <input type="number" class="form-control" name="montant" id="montant" min="0" step="100" />
    </div>

    <button type="submit" class="btn btn-danger w-100">Ajouter la soirée</button>
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
