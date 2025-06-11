<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove – Laissez votre cœur matcher au bon endroit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
  padding: 8px 10px;
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
    border-radius: 0 0 12px 12px;  }

  .navbar-nav .nav-link {
    color: #ff5a5f !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  }

  .navbar-nav .nav-link:hover {
    background-color: white;
    color: #ff5a5f !important;
  }

  .btn-custom {
    background-color: white;
    color: #ff5a5f;
    font-weight: bold;
    text-align: center; 
  }

  .btn-custom:hover {
    background-color: #ff5a5f;
    color: white;
  }
}

.gap-50 {
  gap: 800px;
}

@media (max-width: 991.98px) {
  .navbar-collapse {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: rgb(241, 236, 237);
    z-index: 9999;
    padding: 20px;
    border-radius: 0 0 12px 12px;
  }

  .navbar {
    position: relative;
    z-index: 1000;
  }
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


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="">
      <img src="images/logooo.png" alt="BBLove" style="height: 100px; ">
    </a>

    <!-- Bouton hamburger -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBBLove" aria-controls="navbarBBLove" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu principal aligné à droite -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarBBLove">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="index.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="even.php">Évènements</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="coeur.php">Cœurs brisés</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="surprise.php">Surprises</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="blog.php">Blog</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="a propos.php">À propos</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="contacts.php">Contacts</a></li>
      </ul>

      <div class="d-flex flex-column flex-lg-row gap-1 mt-0 ms-lg-3">
        <a href="login.php" class="btn-custom">Connexion</a>
        <a href="register.php" class="btn-custom">Inscription</a>
      </div>
    </div>
  </div>
</nav>

