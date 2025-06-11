<?php
include'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT nom, prenom, abonnement_type, abonnement_debut, abonnement_fin, date_inscription FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

$today = new DateTime();
$dateInscription = new DateTime($user['date_inscription']);
$joursDepuisInscription = $today->diff($dateInscription)->days;

$abonnementActif = false;
$message = "";
if ($user['abonnement_fin']) {
    $dateFin = new DateTime($user['abonnement_fin']);
    $abonnementActif = $dateFin >= $today;
    $message = $abonnementActif
        ? "Votre abonnement est actif jusqu’au <strong>" . $dateFin->format('d/m/Y') . "</strong>."
        : "Votre abonnement a expiré le <strong>" . $dateFin->format('d/m/Y') . "</strong>.";
} else {
    if ($joursDepuisInscription < 7) {
        $joursRestants = 7 - $joursDepuisInscription;
        $message = "Vous êtes actuellement en période d’essai gratuite. Il vous reste <strong>$joursRestants jour(s)</strong>.";
    } else {
        $message = "Vous n’avez pas encore d’abonnement actif et votre période d’essai a expiré.";
    }
}
?>


  <style>
    .card-abonnement {
        max-width: 600px;
        margin: 40px auto;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        border-radius: 15px;
    }
  </style>
<body>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            ✅ Votre abonnement a été activé avec succès !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

  <div class="container">
    <div class="card card-abonnement p-4">
        <h2 class="text-center mb-4 text-primary">Mon Abonnement</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></p>
        <p><strong>Type d'abonnement :</strong> <?= $user['abonnement_type'] ?? 'N/A' ?></p>
        <p><strong>Date de début :</strong> <?= $user['abonnement_debut'] ?? 'N/A' ?></p>
        <p><strong>Date de fin :</strong> <?= $user['abonnement_fin'] ?? 'N/A' ?></p>
        <p class="<?= $abonnementActif || $joursDepuisInscription < 7 ? 'text-success' : 'text-danger' ?>">
            <?= $message ?>
        </p>

        <?php if (!$abonnementActif && $joursDepuisInscription >= 7): ?>
            <a href="abonnement.php" class="btn btn-warning mt-3 w-100">Souscrire à un abonnement</a>
        <?php endif; ?>
    </div>
  </div>

</body>
</html>
