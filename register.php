<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription - BBLove</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(rgba(255, 182, 193, 0.3), rgba(255, 240, 245, 0.6)), url('images/register.avif') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(15px);
      padding: 30px;
      border-radius: 25px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 550px;
      animation: fadeIn 1.2s ease forwards;
    }

    h2 {
      font-family: 'Playfair Display', serif;
      color: #d6336c;
      text-align: center;
      margin-bottom: 25px;
      font-size: 2.2rem;
    }

    label {
      font-weight: 600;
      color: #6c2d4e;
    }

    .form-control {
      border-radius: 12px;
      border: 1px solid #ccc;
    }

    .btn-danger {
      background-color: #d6336c;
      border: none;
      font-weight: bold;
      font-size: 1.1rem;
      border-radius: 12px;
      transition: background 0.3s ease;
    }

    .btn-danger:hover {
      background-color: #c2185b;
    }

    a {
      color: #c2185b;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    .alert {
      border-radius: 10px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    #age-error {
      color: #b30000;
      font-weight: 500;
      font-size: 0.9rem;
      display: none;
    }

    @media (max-width: 768px) {
      .row {
        display: block;
      }
      .col-md-6 {
        width: 100% !important;
        margin-bottom: 15px;
      }
    }
  </style>
</head>

<body>
  <div class="form-container">
    <h2>Inscription BBLove</h2>
    <form method="POST" action="">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Nom</label>
          <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Prénom</label>
          <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Pays</label>
          <input type="text" name="pays" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Ville</label>
          <input type="text" name="ville" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Téléphone (avec l'indicatif du pays)</label>
          <input type="tel" name="telephone" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Âge</label>
          <input type="number" name="age" class="form-control" min="18" required>
          <p id="age-error">Vous devez avoir au moins 18 ans pour vous inscrire.</p>
        </div>

        <div class="col-md-6 mb-3">
          <label>Mot de passe</label>
          <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label>Confirmer mot de passe</label>
          <input type="password" name="confirmer_mot_de_passe" class="form-control" required>
        </div>
      </div>

      <button type="submit" class="btn btn-danger w-100 mt-3">S'inscrire</button>

      <div class="message text-center mt-3">
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a>.</p>
      </div>

      <?php if (!empty($message)) : ?>
        <div class="alert alert-danger mt-3"><?= htmlspecialchars($message) ?></div>
      <?php endif; ?>
    </form>
  </div>

  <script>
    const ageInput = document.querySelector('input[name="age"]');
    const ageError = document.getElementById('age-error');
    const form = document.querySelector('form');

    ageInput.addEventListener('input', () => {
      const age = parseInt(ageInput.value, 10);
      ageError.style.display = (age < 18) ? 'block' : 'none';
    });

    form.addEventListener('submit', (e) => {
      const age = parseInt(ageInput.value, 10);
      if (isNaN(age) || age < 18) {
        e.preventDefault();
        ageError.style.display = 'block';
        ageInput.focus();
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
