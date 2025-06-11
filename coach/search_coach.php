<?php
include '../db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("INSERT INTO search_coach 
    (nom_utilisateur, prenom_utilisateur, email_utilisateur, telephone_utilisateur, categorie_demande) 
    VALUES (?, ?, ?, ?, ?)");
    
  $stmt->execute([
    $_POST['nom'],
    $_POST['prenom'],
    $_POST['email'],
    $_POST['telephone'],
    $_POST['categorie']
  ]);

  echo "<div style='padding:40px; text-align:center; font-family:sans-serif;'>
          <h2 style='color:#d00000;'>🎯 Demande envoyée !</h2>
          <p>Votre demande a bien été transmise. Un coach spécialisé vous contactera bientôt.</p>
          <a href='../index.php' class='btn btn-danger mt-3'>Retour à l’accueil</a>
        </div>";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trouver un coach</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  @media (max-width: 576px) {
    form.card {
      padding: 1.5rem !important;
    }

    h3 {
      font-size: 1.4rem;
    }

    .btn {
      width: 100%;
    }
  }
</style>

</head>
<body>
    <section class="py-5 bg-light">
  <div class="container">
    <h3 class="text-center text-danger mb-4">👥 Rechercher un coach</h3>
    <form action="" method="POST" class="card p-4 shadow mx-auto" style="max-width: 700px;">
      <div class="row g-3">
        <div class="col-sm-6">
          <label>Nom *</label>
          <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="col-sm-6">
          <label>Prénom *</label>
          <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="col-sm-6">
          <label>Email *</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-sm-6">
          <label>Téléphone *</label>
          <input type="text" name="telephone" class="form-control" required>
        </div>
        <div class="col-12">
          <label>Catégorie *</label>
          <select name="categorie" class="form-select" required>
            <option value="">-- Choisir une catégorie --</option>
            <option value="Conseils de rencontres">Conseils de rencontres</option>
            <option value="Vie de couple">Vie de couple</option>
            <option value="Rupture amoureuse">Rupture amoureuse</option>
            <option value="Sexualité">Sexualité</option>
            <option value="Romantisme">Romantisme</option>
            <option value="Cœurs brisés">Cœurs brisés</option>
          </select>
        </div>
      </div>

      <div class="text-center mt-4">
        <button class="btn btn-danger px-5">🔍 Chercher un coach</button>
      </div>
    </form>
  </div>
</section>

</body>
</html>

