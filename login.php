<?php
include 'db.php'; // Connexion à la base

session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    if (empty($email) || empty($mot_de_passe)) {
        $message = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['identifiant'] = $user['identifiant'];
            $_SESSION['nom'] = $user['nom'];

            if ($_SESSION['role'] === 'coach') {
                $stmt = $pdo->prepare("SELECT categorie_id FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $cat = $stmt->fetchColumn();

                if (empty($cat)) {
                    header("Location: choisir_categorie.php");
                    exit();
                } else {
                    $_SESSION['categorie'] = $cat;
                }
            }

            if ($_SESSION['role'] == 'admin') {
                header('Location: admin_dashboard.php');
            } elseif ($_SESSION['role'] == 'coach') {
                header('Location: coach_dashboard.php');
            } else {
                header('Location: dashboard.php');
            }
            exit();
        } else {
            $message = "Email ou mot de passe incorrect.";
        }
    }
    
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion - BBLove</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: url('images/login.jpg') no-repeat center center fixed;
    background-size: cover;
    position: relative;
    height: 100vh;
    display: flex;
    align-items: center;
    }

    .overlay {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0, 0, 0, 0.6); /* voile noir */
    z-index: 1;
    }

    .form-login {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.16);
    backdrop-filter: blur(10px);
    padding: 50px;
    border-radius: 20px;
    margin-left: 80px;
    width: 100%;
    max-width: 550px;
    animation: fadeIn 1.5s ease forwards;
    }

    @keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateX(-30px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
    }

    .message {
            margin: 20px 0;
        }
        a {
            color:rgb(236, 233, 245);
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }

@media (max-width: 576px) {
  body {
    align-items: flex-start; /* Pour que le formulaire soit en haut */
    padding: 30px 20px;
    height: 800px; /* pour ne pas forcer 100vh */
  }

  .form-login {
    margin-left: 0 !important; /* annule la marge gauche */
    width: 100%;
    max-width: 1200px;
    padding: 30px 20px;
    border-radius: 15px;
    box-sizing: border-box;
  }
}

/*  */

  </style>
</head>
<body>

<div class="overlay"></div>

<div class="form-login">
 
<style>
    .mobile-home-btn {
    display: none; /* Caché par défaut */
    position: fixed;
    left: 20px;
    background-color: #FF5A5F;
    color: white;
    padding: 9px 15px;
    border-radius: 30px;
    
    font-weight: bold;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}

.mobile-home-btn i {
    margin-right: 8px;
    font-size: 1.4rem;
}

.mobile-home-btn:hover {
    transform: scale(1.1);
}

/* Afficher uniquement sur mobile */
@media screen and (max-width: 768px) {
    .mobile-home-btn {
        display: flex;
        align-items: center;
    }
}

</style>
 <a href="index.php" class="mobile-home-btn">
    <i class="fas fa-home"></i> Accueil
</a><br><hr>
    <h2 class="text-center mb-4" style="color:#ff5a5f; font-weight: bold;">Connexion à BBLove</h2>

    <?php if ($message): ?>
        <div class="alert alert-warning"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label style="color: white;">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label style="color: white;">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100" style="background:#ff5a5f;">Se connecter</button>

        <div class="message">
            <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a>.</p>
        </div>

    </form>
</div>

</body>
</html>
