<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Publier sur - <?= htmlspecialchars($categorie) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f2f5;
      padding: 15px;
    }
    .container-custom {
      max-width: 720px;
      margin: auto;
      background: #fff;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }
    h2 {
      color: #ff5a5f;
      text-align: center;
      margin-bottom: 30px;
      font-size: 1.8rem;
    }
    .btn-submit {
      background-color: #ff5a5f;
      color: white;
      border: none;
    }
    .btn-submit:hover {
      background-color: #e14b4f;
    }
    .btn-retour {
      margin-bottom: 20px;
      display: inline-block;
      font-size: 0.95rem;
      padding: 0.4rem 1rem;
    }
    @media (max-width: 576px) {
      .container-custom {
        padding: 20px 15px;
      }
      h2 {
        font-size: 1.4rem;
      }
      .btn-retour {
        width: 100%;
        text-align: center;
        margin-bottom: 25px;
      }
    }
  </style>
</head>
<body>

<div class="container-custom">
  <a href="../admin_dashboard.php" class="btn btn-secondary btn-retour">&larr; Retour au tableau de bord</a>

  <h2>Publier un article sur - <?= htmlspecialchars($categorie) ?></h2>

  <?php if (!empty($message)) echo "<div class='alert alert-success'>$message</div>"; ?>

  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="titre" class="form-label">Titre</label>
      <input type="text" class="form-control" id="titre" name="titre" required>
    </div>

    <div class="mb-3">
      <label for="contenu" class="form-label">Contenu</label>
      <textarea class="form-control" id="contenu" name="contenu" rows="6" required></textarea>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Image (facultative)</label>
      <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-submit w-100">✅ Publier</button>
  </form>
</div>

</body>
</html>
