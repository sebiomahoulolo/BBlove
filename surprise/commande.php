<?php
include '../db.php';
// session_start();
// include '../verifier_abonnement.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sécurisation des champs
    $exp_nom     = $_POST['expediteur_nom'];
    $exp_email   = $_POST['expediteur_email'];
    $exp_tel     = $_POST['expediteur_tel'];
    $exp_ville   = $_POST['expediteur_ville'];

    $dest_nom    = $_POST['destinataire_nom'];
    $dest_email  = $_POST['destinataire_email'];
    $dest_tel    = $_POST['destinataire_tel'];
    $dest_ville  = $_POST['destinataire_ville'];

    $type        = $_POST['type_surprise'];
    $date        = $_POST['date_livraison'];
    $heure       = $_POST['heure_livraison'];
    $message     = $_POST['message'];

    // Statut par défaut : "En attente de devis"
    $statut = 'en_attente';

    $stmt = $pdo->prepare("INSERT INTO commandes_surprise (
        expediteur_nom, expediteur_email, expediteur_tel, expediteur_ville,
        destinataire_nom, destinataire_email, destinataire_tel, destinataire_ville,
        type_surprise, date_livraison, heure_livraison, message, statut
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $exp_nom, $exp_email, $exp_tel, $exp_ville,
        $dest_nom, $dest_email, $dest_tel, $dest_ville,
        $type, $date, $heure, $message, $statut
    ]);

    echo "<script>alert('🎉 Votre commande a bien été envoyée. Vous recevrez bientôt un devis.'); window.location.href='../index.php';</script>";
    exit(); // Important pour ne pas continuer à afficher le formulaire
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove – Laissez votre cœur matcher au bon endroit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
/* === TOP BAR === */
.top-bar {
  background-color: rgb(253, 239, 240);
  height: 75px;
  color: #ff5a5f;
  display: flex;
  align-items: center;
  font-weight: bold;
}

.top-bar .section {
  width: 100%;
  padding: 0 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.top-bar .social-icons a {
  margin-left: 20px;
  font-size: 20px;
  color: #444;
}

.top-bar .social-icons a:hover {
  color: #ff5a5f;
}

/* === NAVBAR === */
.navbar-brand img {
  height: 100px;
}

.navbar-toggler {
  border: none;
}

.navbar-nav .nav-link {
  font-weight: 600;
  padding: 8px 16px;
  color: #333 !important;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar-nav .nav-link:hover {
  color: #ff5a5f !important;
  background-color: rgba(255, 90, 95, 0.1);
  border-radius: 8px;
}

.btn-custom {
  background-color: #ff5a5f;
  color: white;
  border-radius: 30px;
  padding: 8px 20px;
  font-weight: 600;
  transition: background 0.3s;
}

.btn-custom:hover {
  background-color: #fff;
  color: #ff5a5f;
}
@media (max-width: 991.98px) {
  .navbar-collapse {
    background-color:rgb(241, 236, 237);
    padding: 20px;
    border-radius: 0 0 12px 12px;
  }

  .navbar-nav .nav-link {
    color: #ff5a5f !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    text-align: left;
  }

  .navbar-nav .nav-link:hover {
    background-color: white;
    color: #ff5a5f !important;
  }

  .btn-custom {
    background-color: #ff5a5f;
    color: white;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
  }

  .btn-custom:hover {
    background-color: white;
    color: #ff5a5f;
  }
}

.gap-50 {
  gap: 800px;
}
</style>
<header class="top-bar d-none d-md-flex">
 <!-- Top bar (réseaux + contact) -->
<div class=" text-dark py-2 px-3 d-none d-md-flex justify-content-between align-items-center gap-50">
  <div><i class="fa-solid fa-location-dot text-danger"></i> Kindonou, Cotonou | 📞 +229 69 81 30 70</div>
  <div class="ms-auto">
    <a href="https://www.facebook.com/profile.php?id=61576845142304" class="me-3 text-dark"><i class="fab fa-facebook"></i></a>
    <a href="https://wa.me/2290169813066" class="me-3 text-success"><i class="fab fa-whatsapp"></i></a>
    <a href="#" class="me-3 text-primary"><i class="fab fa-linkedin-in"></i></a>
    <a href="#" class="text-danger"><i class="fab fa-tiktok"></i></a>
  </div>
</div>
</header>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="">
      <img src="../images/logooo.png" alt="BBLove" style="height: 70px;">
    </a>

    <!-- Bouton hamburger -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBBLove" aria-controls="navbarBBLove" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu principal -->
    <div class="collapse navbar-collapse" id="navbarBBLove">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="../index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="../even.php">Évènements</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="../coeur.php">Cœurs brisés</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="../surprise.php">Surprises</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="../blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="../a propos.php">À propos</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="../contacts.php">Contacts</a></li>
      </ul>

      <div class="d-flex flex-column flex-lg-row gap-2 mt-3 mt-lg-0 ">
        <a href="../login.php" class="btn-custom">Connexion</a>
        <a href="../register.php" class="btn-custom">Inscription</a>
      </div>
    </div>
  </div>
</nav>

<form action="" method="post" class="bg-white p-4 rounded shadow-sm">
          <h5 class="text-danger mb-3">👤 Vos informations</h5>
          <div class="row g-3">
            <div class="col-md-6">
              <input type="text" name="expediteur_nom" class="form-control" placeholder="Nom complet *" required>
            </div>
            <div class="col-md-6">
              <input type="email" name="expediteur_email" class="form-control" placeholder="E-mail *" required>
            </div>
            <div class="col-md-6">
              <input type="text" name="expediteur_tel" class="form-control" placeholder="Téléphone *" required>
            </div>
            <div class="col-md-6">
              <input type="text" name="expediteur_ville" class="form-control" placeholder="Ville">
            </div>
          </div>

          <hr class="my-4">

          <h5 class="text-danger mb-3">🎯 Destinataire</h5>
          <div class="row g-3">
            <div class="col-md-6">
              <input type="text" name="destinataire_nom" class="form-control" placeholder="Nom complet *" required>
            </div>
            <div class="col-md-6">
              <input type="email" name="destinataire_email" class="form-control" placeholder="Email *">
            </div>
            <div class="col-md-6">
              <input type="number" name="destinataire_tel" class="form-control" placeholder="Téléphone *" required>
            </div>
            <div class="col-md-6">
              <input type="text" name="destinataire_ville" class="form-control" placeholder="Ville ou adresse *" required>
            </div>
          </div>

          <hr class="my-4">

          <h5 class="text-danger mb-3">🎂 Votre surprise</h5>
          <div class="row g-3">
            <div class="col-md-6">
              <select name="type_surprise" class="form-select" required>
                <option value="">Type de surprise *</option>
                <option>Fleurs</option>
                <option>Gâteau</option>
                <option>Nourriture</option>
                <option>Cadeau personnalisé</option>
                <option>Carte d'amour</option>
                <option>Réservation romantique</option>
                <option>Autre</option>
              </select>
            </div>
            <div class="col-md-6">
              <input type="date" name="date_livraison" class="form-control" required>
            </div>
            <div class="col-md-6">
              <input type="time" name="heure_livraison" class="form-control" required>
            </div>
            <div class="col-md-12">
              <textarea name="message" rows="3" class="form-control" placeholder="Votre message d'amour... 💌"></textarea>
            </div>
          </div>

          <div class="text-center mt-4">
            <button class="btn btn-danger px-5">✅ Envoyer la commande</button>
          </div>
        </form>
 </body>
</html>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="footer.css">

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-block logo-block">
      <div class="logo-container">
        <img src="../images/logooo.png" alt="BBLove Logo">
      </div>
      <p>Rencontrez l'amour en toute sécurité. Rejoignez notre communauté pour des connexions authentiques.</p>
      <div class="btn-container">
        <a href="../register.php" class="btn-start">Commencez</a>
      </div>
    </div>

    <div class="footer-block">
      <h4>Navigation</h4>
      <ul>
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="../even.php">Événements</a></li>
        <li><a href="../coeur.php">Coeurs brisés</a></li>
        <li><a href="../surprise.php">Surprise</a></li>
        <li><a href="../blog.php">Blog</a></li>
        <li><a href="../a propos.php">À propos</a></li>
        <li><a href="../contacts.php">Contacts</a></li>
      </ul>
    </div>

    <div class="footer-block">
      <h4>Contact</h4>
      <p><i class="fa fa-map-marker-alt"></i> Kindonou, Cotonou</p>
      <p><i class="fa fa-phone-alt"></i> +229 01 69 81 30 70</p>
      <p><i class="fa fa-envelope"></i> contactbblove2@gmail.com</p>
    </div>

    <div class="footer-block">
      <h4>Réseaux sociaux</h4>
      <div class="social-links">
        <a href="https://www.facebook.com/profile.php?id=61576845142304"><i class="fab fa-facebook-f"></i></a>
        <a href="https://wa.me/2290169813066"><i class="fab fa-whatsapp"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>

    <div class="footer-block presence-block">
      <h4>Nos présences</h4>
      <div class="flags">
        <img src="../img/benin.png" alt="Bénin">
        <img src="../img/senegal.png" alt="Sénégal">
        <img src="../img/cote-divoire.png" alt="Côte d'Ivoire">
        <img src="../img/mali.png" alt="Mali">
        <img src="../img/togo.png" alt="Togo">
        <img src="../img/france.png" alt="France">
        <img src="../img/usa.png" alt="USA">
      </div>
    </div>
  </div>

  <hr class="footer-separator">

  <div class="footer-bottom">
    <p>&copy; 2025 <strong>BBLove</strong>. Tous droits réservés — 
      <strong><a href="https://fhcgroupebenin.com/">FHC GROUPE sarl</a></strong>.
    </p>
    <p>
      <a href="mentions-legales.php">Mentions légales</a> |
      <a href="../privacy_policy.php">Politique de confidentialité</a>
    </p>
  </div>
</footer>

<!-- Bouton WhatsApp -->
<a href="https://wa.me/2290169813066" 
   style="position: fixed; bottom: 20px; left: 20px; background-color: #25D366; color: white; border-radius: 50px; padding: 10px 10px; font-size: 30px; text-decoration: none; z-index: 9999;" 
   target="_blank">
   <i class="fab fa-whatsapp"></i>
</a>

<style>
.site-footer {
  background-color: rgb(253, 239, 240);
  font-family: 'Segoe UI', sans-serif;
  color: #2c2c2c;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  padding: 40px 20px;
}

.footer-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 30px;
  max-width: 1200px;
  margin: auto;
}

.footer-block h4 {
  color: #f44c61;
  text-align: left;
}

.footer-block ul {
  list-style: none;
  padding: 0;
}

.footer-block ul li a {
  color: #2c2c2c;
  text-decoration: none;
  display: block;
  margin-bottom: 8px;
}

.footer-block p {
  font-size: 16px;
  text-align: justify;
}

.logo-container {
  text-align: justify;
}

.logo-container img {
  width: 120px;
  max-width: 100%;
  margin-bottom: 10px;
}

.btn-container {
  text-align: center;
  margin-top: 10px;
}

.btn-start {
  background-color: #f44c61;
  color: white;
  padding: 10px 20px;
  border-radius: 25px;
  text-decoration: none;
  font-weight: bold;
  display: inline-block;
  transition: background 0.3s ease;
}

.btn-start:hover {
  background-color: #e53e55;
}

.social-links {
  display: flex;
  align-items: center;
  gap: 12px;
}

.social-links a {
  font-size: 26px;
}

.social-links i.fa-facebook-f { color: #0000ff; }
.social-links i.fa-whatsapp { color: #25D366; }
.social-links i.fa-linkedin-in { color: #0077b5; }
.social-links i.fa-tiktok { color: #f71b1b; }

.presence-block {
  text-align: center;
}

.flags {
  display: flex;
  flex-wrap: nowrap;
  justify-content: center;
  gap: 8px;
  overflow-x: auto;
  padding-top: 10px;
}

.flags img {
  width: 40px;
  height: auto;
}

.footer-separator {
  margin: 30px auto;
  border: none;
  height: 3px;
  background-color: #fbb6c2;
  width: 80%;
}

.footer-bottom {
  text-align: center;
  font-size: 14px;
  padding-top: 10px;
  line-height: 1.6;
}

.footer-bottom a {
  color: #0077b6;
  text-decoration: none;
  margin: 0 5px;
}

/* Responsive mobile: 2 colonnes */
@media (max-width: 768px) {
  .footer-container {
    grid-template-columns: repeat(2, 1fr);
    text-align: center;
  }

  .footer-block h4,
  .footer-block p,
  .footer-block ul li a {
    text-align: center;
  }

  .footer-block {
    padding: 10px 0;
  }

  .flags {
    justify-content: center;
    flex-wrap: nowrap;
  }
}

@media (max-width: 480px) {
  .footer-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
  }

  .btn-start {
    width: 100%;
  }

  .social-links {
    justify-content: center;
  }

  .flags {
    flex-wrap: wrap;
    justify-content: center;
  }

  .flags img {
    margin: 3px;
    width: 30px;
  }
}
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
