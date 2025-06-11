<?php
include '../db.php';

if (!isset($_GET['id'])) {
    echo "ID utilisateur manquant.";
    exit;
}

$id = intval($_GET['id']);

// Récupérer les données du profil
$stmt = $pdo->prepare("SELECT * FROM profils WHERE user_id = ?");
$stmt->execute([$id]);
$profil = $stmt->fetch();

if (!$profil) {
    echo "Profil non trouvé.";
    exit;
}
?>

<h2>Profil de l'utilisateur</h2>
<ul>
  <li><strong>Âge :</strong> <?= htmlspecialchars($profil['age']) ?></li>
  <li><strong>Ville :</strong> <?= htmlspecialchars($profil['ville']) ?></li>
  <li><strong>Sexe :</strong> <?= htmlspecialchars($profil['sex']) ?></li>
  <li><strong>Bio :</strong> <?= nl2br(htmlspecialchars($profil['bio'])) ?></li>
  <li><strong>Photo :</strong><br>
    <?php if (!empty($profil['photo'])): ?>
      <img src="../uploads/<?= htmlspecialchars($profil['photo']) ?>" width="150">
    <?php else: ?>
      Aucune photo.
    <?php endif; ?>
  </li>
  <li><strong>Intérêts :</strong> <?= htmlspecialchars($profil['interets']) ?></li>
  <li><strong>Description du partenaire recherché :</strong> <?= htmlspecialchars($profil['description_partenaire']) ?></li>
  <li><strong>Tranche d'âge recherchée :</strong> <?= htmlspecialchars($profil['tranche_age_recherche']) ?></li>
  <li><strong>Lieu de recherche :</strong> <?= htmlspecialchars($profil['lieu_recherche']) ?></li>
  <li><strong>Religion (partenaire) :</strong> <?= htmlspecialchars($profil['religion_partenaire']) ?></li>
  <li><strong>Religion (utilisateur) :</strong> <?= htmlspecialchars($profil['religion_utilisateur']) ?></li>
  <li><strong>Métier :</strong> <?= htmlspecialchars($profil['metier']) ?></li>
  <li><strong>Situation amoureuse :</strong> <?= htmlspecialchars($profil['situation_amoureuse']) ?></li>
  <li><strong>Fumeur :</strong> <?= htmlspecialchars($profil['fumeur']) ?></li>
  <li><strong>Alcool :</strong> <?= htmlspecialchars($profil['alcool']) ?></li>
</ul>
<a href="javascript:history.back()" class="btn btn-primary">⬅️ Retour</a>
