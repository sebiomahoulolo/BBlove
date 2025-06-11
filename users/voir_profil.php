<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Aucun utilisateur sélectionné.</div>";
    exit;
}

$user_id = $_GET['id'];

// Récupère les informations du profil
$stmt = $pdo->prepare("SELECT u.nom, u.prenom, u.email, p.* FROM users u 
                       JOIN profils p ON u.id = p.user_id 
                       WHERE u.id = ?");
$stmt->execute([$user_id]);
$profil = $stmt->fetch();

if (!$profil) {
    echo "<div class='alert alert-warning'>Profil non trouvé.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Voir Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-center text-danger mb-4">👤 Profil de <?= htmlspecialchars($profil['nom']) ?> <?= htmlspecialchars($profil['prenom']) ?></h2>

  <div class="card shadow-sm p-4">
    <div class="row">
      <div class="col-md-4 text-center">
        <?php if (!empty($profil['photo'])): ?>
          <img src="<?= htmlspecialchars($profil['photo']) ?>" class="img-fluid rounded" style="max-height: 300px;">
        <?php else: ?>
          <p><em>Aucune photo de profil</em></p>
        <?php endif; ?>
      </div>

      <div class="col-md-8">
        <p><strong>Âge :</strong> <?= htmlspecialchars($profil['age']) ?> ans</p>
        <p><strong>Ville :</strong> <?= htmlspecialchars($profil['ville']) ?></p>
        <p><strong>Bio :</strong> <?= nl2br(htmlspecialchars($profil['bio'])) ?></p>
        <p><strong>Intérêts :</strong> <?= htmlspecialchars($profil['interets']) ?></p>
        <p><strong>Religion :</strong> <?= htmlspecialchars($profil['religion_utilisateur']) ?></p>
        <p><strong>Situation amoureuse :</strong> <?= htmlspecialchars($profil['situation_amoureuse']) ?></p>
        <p><strong>Fumeur :</strong> <?= htmlspecialchars($profil['fumeur']) ?></p>
        <p><strong>Alcool :</strong> <?= htmlspecialchars($profil['alcool']) ?></p>
        <hr>
        <h5 class="text-danger">💖 Partenaire recherché :</h5>
        <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($profil['description_partenaire'])) ?></p>
        <p><strong>Tranche d'âge :</strong> <?= htmlspecialchars($profil['tranche_age_recherche']) ?></p>
        <p><strong>Lieu recherché :</strong> <?= htmlspecialchars($profil['lieu_recherche']) ?></p>
        <p><strong>Religion du partenaire :</strong> <?= htmlspecialchars($profil['religion_partenaire']) ?></p>
      </div>
    </div>
  </div>

  <div class="mt-4 text-center">
    <a href="dashboard.php?page=utilisateurs" class="btn btn-secondary">🔙 Retour</a>
  </div>
</div>
</body>
</html>
