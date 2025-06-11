<?php
include '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom        = $_POST['nom'];
  $email      = $_POST['email'];
  $telephone  = $_POST['telephone'];
  $type       = $_POST['type_seance'];
  $message    = $_POST['message'] ?? '';

  $stmt = $pdo->prepare("INSERT INTO coaching_rdv (nom, email, telephone, type_seance, message, statut, vue) VALUES (?, ?, ?, ?, ?, 'en_attente', 0)");
  $stmt->execute([$nom, $email, $telephone, $type, $message]);

  echo "<div style='text-align: center; padding: 60px; font-family: sans-serif;'>
    <h2 style='color: #ff5a5f;'>Merci pour votre réservation !</h2>
    <p>Votre demande de séance <strong>$type</strong> a bien été enregistrée.</p>
    <p>Nous vous contacterons sous peu pour confirmer votre créneau.</p>
    <a href='../index.php' class='btn btn-danger mt-3'>Retour à l’accueil</a>
  </div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réserver une séance</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f7f9fb;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .section-coaching {
      background-color: #ffffff;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.07);
      padding: 40px;
      margin: 40px auto;
      max-width: 600px;
    }

    .section-coaching h2 {
      color: #005fa5;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-label {
      font-weight: 600;
      color: #333;
    }

    .form-control,
    .form-select {
      padding: 14px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #005fa5;
      box-shadow: 0 0 0 0.15rem rgba(0, 95, 165, 0.25);
    }

    .btn-custom {
      background-color: #005fa5;
      color: #fff;
      border-radius: 8px;
      padding: 12px 24px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #004580;
    }

    @media (max-width: 576px) {
      .section-coaching {
        padding: 25px;
        margin: 20px;
      }
    }
  </style>
</head>
<body>

<div class="section-coaching">
  <h2>Réserver une séance de coaching</h2>
  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Nom complet *</label>
      <input type="text" name="nom" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Adresse e-mail *</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Téléphone *</label>
      <input type="text" name="telephone" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Type de séance *</label>
      <select name="type_seance" class="form-select" required>
        <option value="">-- Choisissez --</option>
        <option value="Gratuite">Séance gratuite (30 min)</option>
        <option value="Payante">Séance complète (1h - 10 000 FCFA)</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Message (optionnel)</label>
      <textarea name="message" rows="4" class="form-control" placeholder="Expliquez brièvement votre situation..."></textarea>
    </div>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-custom w-100">✅ Réserver maintenant</button>
    </div>
  </form>
</div>

</body>
</html>
