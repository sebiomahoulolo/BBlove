<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Modification du mot de passe
if (isset($_POST['modifier_mdp'])) {
    $ancien = $_POST['ancien'];
    $nouveau = $_POST['nouveau'];
    $confirmer = $_POST['confirmer'];

    $stmt = $pdo->prepare("SELECT mot_de_passe FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $mot_de_passe_hash = $stmt->fetchColumn();

    if (!password_verify($ancien, $mot_de_passe_hash)) {
        $message = "<div class='alert alert-danger'>Ancien mot de passe incorrect.</div>";
    } elseif ($nouveau !== $confirmer) {
        $message = "<div class='alert alert-warning'>Les mots de passe ne correspondent pas.</div>";
    } else {
        $newHash = password_hash($nouveau, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET mot_de_passe = ? WHERE id = ?");
        $stmt->execute([$newHash, $user_id]);
        $message = "<div class='alert alert-success'>Mot de passe mis à jour.</div>";
    }
}

// Suppression du compte
if (isset($_POST['supprimer_compte'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    session_destroy();
    header("Location: goodbye.php"); // ou redirection vers la page d'accueil
    exit();
}
?>

<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-danger">⚙️ Paramètres du compte</h2>
    <?= $message ?>

    <form method="POST" class="mt-4 p-4 bg-white rounded shadow-sm">
        <h5 class="mb-3 text-primary">🔐 Modifier le mot de passe</h5>
        <div class="mb-3">
            <label>Ancien mot de passe</label>
            <input type="password" name="ancien" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nouveau mot de passe</label>
            <input type="password" name="nouveau" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirmer" class="form-control" required>
        </div>
        <button type="submit" name="modifier_mdp" class="btn btn-success">Mettre à jour</button>
    </form>

    <form method="POST" class="mt-4 p-4 bg-white rounded shadow-sm">
        <h5 class="mb-3 text-danger">🗑️ Supprimer mon compte</h5>
        <p>Cette action est irréversible. Toutes vos données seront supprimées.</p>
        <button type="submit" name="supprimer_compte" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')">Supprimer mon compte</button>
    </form>
</div>

</body>
