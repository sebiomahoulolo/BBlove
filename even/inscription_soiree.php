<?php
include '../db.php';

$message = '';
$eventId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$event = $pdo->prepare("SELECT * FROM evenements WHERE id = ?");
$event->execute([$eventId]);
$eventData = $event->fetch();

$isPayant = $eventData && $eventData['payant'];


// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $evenement_id = $_POST['evenement_id'];

    $stmt = $pdo->prepare("INSERT INTO participants (nom, prenom, email, telephone, evenement_id) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nom, $prenom, $email, $telephone, $evenement_id])) {
        $message = "Inscription réussie !";
    } else {
        $message = "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription à une soirée - BBLove</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #fff0f0;
      font-family: 'Poppins', sans-serif;
    }
    .form-container {
      max-width: 500px;
      margin: 50px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    h2 {
      color: #ff5a5f;
    }
  </style>
</head>
<body>

<div class="form-container">
<button class="btn"><a href="../even.php" style="text-decoration: none; color: #ff5a5f;">Retour</a></button>

  <h2 class="text-center mb-4">Inscription à la soirée</h2>

  <?php if ($message): ?>
    <div class="alert alert-success text-center"><?php echo $message; ?></div>
  <?php endif; ?>

  <?php if ($isPayant): ?>
  <div class="alert alert-warning text-center">
    <strong>⚠ Cet événement est payant.</strong> Merci de procéder au paiement pour valider votre inscription.
  </div>
  <!-- Exemple : lien vers une page de paiement ou affichage d'infos -->
  <div class="text-center mb-3">
    <a href="paiement.php?event_id=<?php echo $eventId; ?>" class="btn btn-primary">Payer maintenant</a>
  </div>
<?php else: ?>
  <!-- Formulaire d'inscription classique -->
  <form method="POST">
    <input type="hidden" name="evenement_id" value="<?php echo $eventId; ?>">

    <div class="mb-3">
      <label>Nom</label>
      <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Prénom</label>
      <input type="text" name="prenom" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Téléphone</label>
      <input type="text" name="telephone" class="form-control">
    </div>
    <button type="submit" class="btn btn-danger w-100" style="background:#ff5a5f;">S'inscrire maintenant</button>
  </form>
<?php endif; ?>

</div>

</body>
</html>
