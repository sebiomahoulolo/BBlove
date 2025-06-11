<?php
session_start();
include '../db.php';

// Vérification admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Gestion du changement de mot de passe
if (isset($_POST['changer_mdp'])) {
    $ancien = $_POST['ancien_mdp'];
    $nouveau = $_POST['nouveau_mdp'];
    $confirmer = $_POST['confirmer_mdp'];

    if ($nouveau === $confirmer) {
        $stmt = $pdo->prepare("SELECT mot_de_passe FROM admins WHERE id = ?");
        $stmt->execute([$admin_id]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($ancien, $admin['mot_de_passe'])) {
            $nouveau_hash = password_hash($nouveau, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admins SET mot_de_passe = ? WHERE id = ?");
            $stmt->execute([$nouveau_hash, $admin_id]);
            $message = "✅ Mot de passe modifié avec succès.";
        } else {
            $erreur = "❌ Ancien mot de passe incorrect.";
        }
    } else {
        $erreur = "❌ Les nouveaux mots de passe ne correspondent pas.";
    }
}

// Gestion de la suppression de compte
if (isset($_POST['supprimer_compte'])) {
    $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->execute([$admin_id]);
    session_destroy();
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Paramètres Administrateur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
    }
    .param-container {
      max-width: 700px;
      margin: auto;
      background-color: #fff;
      padding: 2rem;
      margin-top: 3rem;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }
    .param-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #005fa5;
      text-align: center;
      margin-bottom: 2rem;
    }
    .section-title {
      font-size: 1.2rem;
      font-weight: 600;
      margin-top: 2rem;
      color: #333;
    }
    .form-label {
      font-weight: 500;
      color: #555;
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-custom {
      border-radius: 8px;
      padding: 0.5rem 1.5rem;
      font-weight: 600;
      transition: 0.3s ease;
    }
    .btn-save {
      background-color: #005fa5;
      color: #fff;
      border: none;
    }
    .btn-save:hover {
      background-color: #004080;
    }
    .btn-danger-outline {
      border: 2px solid #dc3545;
      color: #dc3545;
      background-color: transparent;
    }
    .btn-danger-outline:hover {
      background-color: #dc3545;
      color: #fff;
    }
    .btn-back {
      background-color: #6c757d;
      color: white;
    }
    .btn-back:hover {
      background-color: #495057;
    }
  </style>
</head>
<body>

<div class="param-container">
  <h2 class="param-title">⚙️ Paramètres du compte administrateur</h2>

  <?php if (isset($message)): ?>
    <div class="alert alert-success"><?= $message ?></div>
  <?php elseif (isset($erreur)): ?>
    <div class="alert alert-danger"><?= $erreur ?></div>
  <?php endif; ?>

  <!-- Modifier le mot de passe -->
  <h5 class="section-title">🔐 Modifier le mot de passe</h5>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Mot de passe actuel</label>
      <input type="password" name="ancien_mdp" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Nouveau mot de passe</label>
      <input type="password" name="nouveau_mdp" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Confirmer le mot de passe</label>
      <input type="password" name="confirmer_mdp" class="form-control" required>
    </div>
    <button type="submit" name="changer_mdp" class="btn btn-save btn-custom">✅ Enregistrer</button>
  </form>

  <!-- Supprimer le compte -->
  <h5 class="section-title text-danger">🗑️ Supprimer le compte</h5>
  <form method="post" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce compte ? Cette action est irréversible.')">
    <button type="submit" name="supprimer_compte" class="btn btn-danger-outline btn-custom">Supprimer mon compte</button>
  </form>

  <!-- Bouton de retour -->
  <div class="mt-4 text-center">
    <a href="../admin_dashboard.php" class="btn btn-back btn-custom">⬅️ Retour au tableau de bord</a>
  </div>
</div>

</body>
</html>
