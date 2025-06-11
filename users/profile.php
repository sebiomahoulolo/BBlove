<?php
include 'db.php';

$user_id = $_SESSION['user_id'];

// Utilisation de $pdo
$stmt = $pdo->prepare("SELECT * FROM profils WHERE user_id = ?");
$stmt->execute([$user_id]);
$profil = $stmt->fetch();

if (!$profil) {
    echo "<div class='alert alert-warning'>Profil non trouvé.</div>";
    return;
}
?>

<style>
  .profil-container {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
  .profil-photo {
    width: 130px;
    height: 130px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #ff5a5f;
  }
  .profil-table td {
    padding: 10px 15px;
    vertical-align: top;
  }
</style>

<div class="profil-container">
  <div class="text-center mb-4">
    <?php if (!empty($profil['photo'])): ?>
      <img src="<?= htmlspecialchars($profil['photo']) ?>" class="profil-photo" alt="Photo">
    <?php else: ?>
      <img src="images/default.jpg" class="profil-photo" alt="Photo">
    <?php endif; ?>
    <h3 class="mt-3"><?= htmlspecialchars($_SESSION['nom']) ?>, <?= $profil['age'] ?? 'N/A' ?></h3>
    <a href="dashboard.php?page=creerprofil" class="btn btn-outline-danger mt-2">✏️ Modifier le Profil</a>
  </div>

  <h5 class="mb-3">À propos de moi</h5>
  <p><?= nl2br(htmlspecialchars($profil['bio'])) ?></p>

  <h5 class="mt-4">Informations générales</h5>
  <table class="table profil-table">
    <tr><td><strong>Ville :</strong></td><td><?= htmlspecialchars($profil['ville']) ?></td></tr>
    <tr><td><strong>Métier :</strong></td><td><?= htmlspecialchars($profil['metier']) ?></td></tr>
    <tr><td><strong>Religion :</strong></td><td><?= htmlspecialchars($profil['religion_utilisateur']) ?></td></tr>
    <tr><td><strong>Situation amoureuse :</strong></td><td><?= htmlspecialchars($profil['situation_amoureuse']) ?></td></tr>
    <tr><td><strong>Vous fumez :</strong></td><td><?= htmlspecialchars($profil['fumeur']) ?></td></tr>
    <tr><td><strong>Vous buvez de l’alcool :</strong></td><td><?= htmlspecialchars($profil['alcool']) ?></td></tr>
  </table>

  <h5 class="mt-4">Centres d’intérêt</h5>
  <p><?= nl2br(htmlspecialchars($profil['interets'])) ?></p>

  <h5 class="mt-4">Ce que je recherche</h5>
  <table class="table profil-table">
    <tr><td><strong>Tranche d’âge souhaitée :</strong></td><td><?= htmlspecialchars($profil['tranche_age_recherche']) ?></td></tr>
    <tr><td><strong>Ville ou pays :</strong></td><td><?= htmlspecialchars($profil['lieu_recherche']) ?></td></tr>
    <tr><td><strong>Religion du partenaire :</strong></td><td><?= htmlspecialchars($profil['religion_partenaire']) ?></td></tr>
    <tr><td><strong>Description de l’homme parfait :</strong></td><td><?= nl2br(htmlspecialchars($profil['description_partenaire'])) ?></td></tr>
  </table>
</div>
