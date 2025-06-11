<?php
include 'db.php';


if (!isset($_SESSION['user_id'])) {
  die("Utilisateur non connecté.");
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bio = $_POST['bio'];
  $ville = $_POST['ville'];
  $age = $_POST['age'];
  $sex = $_POST['sex'];
  $photo = $_FILES['photo']['name'];
  $interets = $_POST['interets'];
  $description_partenaire = $_POST['description_partenaire'];
  $tranche_age_recherche = $_POST['tranche_age_recherche'];
  $lieu_recherche = $_POST['lieu_recherche'];
  $religion_partenaire = $_POST['religion_partenaire'];
  $religion_utilisateur = $_POST['religion_utilisateur'];
  $metier = $_POST['metier'];
  $situation_amoureuse = $_POST['situation_amoureuse'];
  $fumeur = $_POST['fumeur'];
  $alcool = $_POST['alcool'];


  $upload_dir = 'uploads/';
  $photo_path = $profil['photo'] ?? null;

  // ✅ Gérer l’envoi de la nouvelle photo et enregistrer l’ancienne dans la galerie
  if (!empty($photo)) {
    $new_photo_path = $upload_dir . time() . '_' . basename($photo);

    // 🔁 Sauvegarder l’ancienne dans la galerie
    if (!empty($profil['photo'])) {
      $old_photo = $profil['photo'];
      $stmt = $pdo->prepare("INSERT INTO galerie (user_id, type, fichier, legende) VALUES (?, 'photo', ?, ?)");
      $stmt->execute([$user_id, $old_photo, 'Ancienne photo de profil']);
    }

    // 🚀 Déplacer la nouvelle photo
    move_uploaded_file($_FILES['photo']['tmp_name'], $new_photo_path);
    $photo_path = $new_photo_path;
  }

  // ✅ Mise à jour ou insertion
if ($profil) {
  // ✅ Mise à jour du profil existant
  $stmt = $pdo->prepare("UPDATE profils SET bio=?, ville=?, age=?, sex=?, photo=?, interets=?, description_partenaire=?, tranche_age_recherche=?, lieu_recherche=?, religion_partenaire=?, religion_utilisateur=?, metier=?, situation_amoureuse=?, fumeur=?, alcool=? WHERE user_id=?");
  $stmt->execute([$bio, $ville, $age, $sex, $photo_path, $interets, $description_partenaire, $tranche_age_recherche, $lieu_recherche, $religion_partenaire, $religion_utilisateur, $metier, $situation_amoureuse, $fumeur, $alcool, $user_id]);

} else {
  // ✅ Insertion si aucun profil n'existe
  $stmt = $pdo->prepare("INSERT INTO profils (user_id, bio, ville, age, sex, photo, interets, description_partenaire, tranche_age_recherche, lieu_recherche, religion_partenaire, religion_utilisateur, metier, situation_amoureuse, fumeur, alcool) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([$user_id, $bio, $ville, $age, $sex, $photo_path, $interets, $description_partenaire, $tranche_age_recherche, $lieu_recherche, $religion_partenaire, $religion_utilisateur, $metier, $situation_amoureuse, $fumeur, $alcool]);
}


  echo "<div class='alert alert-success'>Profil enregistré avec succès.</div>";
  header("Location: dashboard.php?page=voirprofil");
  exit();
}
?>




<style>
  .profile-form {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
  .profile-photo {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #ff5a5f;
  }
</style>

<div class="container mt-4">
  <div class="profile-form">

    <h3 class="mb-4 text-danger">Créer ou Modifier mon profil</h3>

    <form method="post" enctype="multipart/form-data">

      <!-- Photo actuelle -->
      <div class="mb-4 text-center">
        <?php 
          if (!empty($profil['photo'])): ?>
            <img src="<?= htmlspecialchars($profil['photo']) ?>" alt="Photo de profil" class="profile-photo">
          <?php else: ?>
            <img src="images/default.jpg" alt="Photo par défaut" class="profile-photo">
          <?php endif; 
        ?>
      </div>

      <!-- Champs -->
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Âge</label>
          <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($profil['age'] ?? '') ?>" required>
        </div>

         <div class="col-md-6">
          <label class="form-label">Sexe</label>
          <select name="sex" class="form-select" required>
            <option value="">Choisir</option>
            <option value="Homme" <?= (isset($profil['sex']) && $profil['sex'] === 'Homme') ? 'selected' : '' ?>>Homme</option>
            <option value="Femme" <?= (isset($profil['sex']) && $profil['sex'] === 'Femme') ? 'selected' : '' ?>>Femme</option>
            <option value="Autre" <?= (isset($profil['sex']) && $profil['sex'] === 'Autre') ? 'selected' : '' ?>>Autre</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Ville</label>
          <input type="text" name="ville" class="form-control" value="<?= htmlspecialchars($profil['ville'] ?? '') ?>" required>
        </div>

        <div class="col-md-12">
          <label class="form-label">À propos de moi</label>
          <textarea name="bio" class="form-control" rows="4" required><?= htmlspecialchars($profil['bio'] ?? '') ?></textarea>
        </div>

        <div class="col-md-12">
          <label class="form-label">Changer la photo de profil</label>
          <input type="file" name="photo" class="form-control">
        </div>

        <div class="col-md-12">
            <label class="form-label">Centres d’intérêt</label>
            <textarea name="interets" class="form-control" rows="3"><?= htmlspecialchars($profil['interets'] ?? '') ?></textarea>
          </div>

          <div class="col-md-12">
            <label class="form-label">Décrivez votre homme/femme idéal</label>
            <textarea name="description_partenaire" class="form-control" rows="3"><?= htmlspecialchars($profil['description_partenaire'] ?? '') ?></textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label">Tranche d’âge recherchée</label>
            <input type="text" name="tranche_age_recherche" class="form-control" value="<?= htmlspecialchars($profil['tranche_age_recherche'] ?? '') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label">Ville ou pays souhaité</label>
            <input type="text" name="lieu_recherche" class="form-control" value="<?= htmlspecialchars($profil['lieu_recherche'] ?? '') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label">Religion de l’homme recherché</label>
            <select name="religion_partenaire" class="form-select">
              <option value="">Choisir</option>
              <option <?= ($profil['religion_partenaire'] ?? '') === 'Chrétien' ? 'selected' : '' ?>>Chrétien</option>
              <option <?= ($profil['religion_partenaire'] ?? '') === 'Musulman' ? 'selected' : '' ?>>Musulman</option>
              <option <?= ($profil['religion_partenaire'] ?? '') === 'Autre' ? 'selected' : '' ?>>Autre</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Votre religion</label>
            <select name="religion_utilisateur" class="form-select">
              <option value="">Choisir</option>
              <option <?= ($profil['religion_utilisateur'] ?? '') === 'Chrétien' ? 'selected' : '' ?>>Chrétien</option>
              <option <?= ($profil['religion_utilisateur'] ?? '') === 'Musulman' ? 'selected' : '' ?>>Musulman</option>
              <option <?= ($profil['religion_utilisateur'] ?? '') === 'Autre' ? 'selected' : '' ?>>Autre</option>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">Votre métier</label>
            <input type="text" name="metier" class="form-control" value="<?= htmlspecialchars($profil['metier'] ?? '') ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label">Situation matrimoniale</label>
            <select name="situation_amoureuse" class="form-select">
              <option value="">Choisir</option>
              <option <?= ($profil['situation_amoureuse'] ?? '') === 'Célibataire' ? 'selected' : '' ?>>Célibataire avec enfant</option>
              <option <?= ($profil['situation_amoureuse'] ?? '') === 'Célibataire' ? 'selected' : '' ?>>Célibataire sans enfant</option>
              <option <?= ($profil['situation_amoureuse'] ?? '') === 'Divorcé(e)' ? 'selected' : '' ?>>Divorcé(e)</option>
              <option <?= ($profil['situation_amoureuse'] ?? '') === 'Veuf(ve)' ? 'selected' : '' ?>>Veuf(ve)</option>
              <option <?= ($profil['situation_amoureuse'] ?? '') === 'En couple' ? 'selected' : '' ?>>En couple</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Vous fumez ?</label>
            <select name="fumeur" class="form-select">
              <option value="">Choisir</option>
              <option <?= ($profil['fumeur'] ?? '') === 'Oui' ? 'selected' : '' ?>>Oui</option>
              <option <?= ($profil['fumeur'] ?? '') === 'Souvent' ? 'selected' : '' ?>>Souvent</option>
              <option <?= ($profil['fumeur'] ?? '') === 'Parfois' ? 'selected' : '' ?>>Parfois</option>
              <option <?= ($profil['fumeur'] ?? '') === 'Rarement' ? 'selected' : '' ?>>Rarement</option>
              <option <?= ($profil['fumeur'] ?? '') === 'Non' ? 'selected' : '' ?>>Non</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Vous buvez de l’alcool ?</label>
            <select name="alcool" class="form-select">
              <option value="">Choisir</option>
              <option <?= ($profil['alcool'] ?? '') === 'Oui' ? 'selected' : '' ?>>Oui</option>
              <option <?= ($profil['alcool'] ?? '') === 'Souvent' ? 'selected' : '' ?>>Souvent</option>
              <option <?= ($profil['alcool'] ?? '') === 'Parfois' ? 'selected' : '' ?>>Parfois</option>
              <option <?= ($profil['alcool'] ?? '') === 'Rarement' ? 'selected' : '' ?>>Rarement</option>
              <option <?= ($profil['alcool'] ?? '') === 'Non' ? 'selected' : '' ?>>Non</option>
            </select>
          </div>


      </div>

      <!-- Bouton -->
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-danger px-5">Enregistrer</button>
      </div>

    </form>
  </div>
</div>
