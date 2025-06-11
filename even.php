<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<section style="background-color: rgb(253, 239, 240); padding: 20px; margin-top: 40px;">

  <h2 style="color: #FF5A5F; font-weight: bold; text-align: center; padding: 10px; font-size: 2.5rem;">
    Évènements BBLove
  </h2>

  <!-- Carousel -->
  <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="container">
          <div class="row align-items-center g-4">
            <div class="col-lg-6">
              <img src="images/even.avif" class="img-fluid rounded w-100" alt="Événement 1">
            </div>
            <div class="col-lg-6">
              <h3 style="color: #FF5A5F; font-weight: bold;">Des évènements pour vous</h3>
              <p class="p-3" style="border-left: 5px solid #FF5A5F; background-color: #fff; color: #000; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                Avec BBLove, découvrez des évènements organisés pour connecter les cœurs. Vous pourrez rencontrer des personnes partageant vos passions et intérêts.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item">
        <div class="container">
          <div class="row align-items-center g-4">
            <div class="col-lg-6 order-lg-2">
              <img src="images/atelier.avif" class="img-fluid rounded w-100" alt="Événement 2">
            </div>
            <div class="col-lg-6 order-lg-1">
              <h3 style="color: #FF5A5F; font-weight: bold;">Atelier de Communication</h3>
              <p class="p-3" style="border-left: 5px solid #FF5A5F; color: #000;  background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                Participez à notre atelier sur la communication efficace pour des relations durables.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-item">
        <div class="container">
          <div class="row align-items-center g-4">
            <div class="col-lg-6">
              <img src="images/renctre.jpg" class="img-fluid rounded w-100" alt="Événement 3">
            </div>
            <div class="col-lg-6">
              <h3 style="color: #FF5A5F; font-weight: bold;">Rencontre en Présentiel ou en ligne</h3>
              <p class="p-3" style="border-left: 5px solid #FF5A5F; color: #000;  background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                Venez rencontrer des personnes en face à face lors de notre événement en présentiel ou en ligne pour des discussions authentiques.
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Contrôles du carousel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>
</section>


  <!-- Section événements cards -->
<div style="padding-top: 80px;">
    <h2 style="color: #FF5A5F; font-weight: bold; text-align: center;">Faite des évènements une rencontre inoubliable</h2>
  <p style="text-align: center; font-weight: bold; color:rgb(65, 62, 62); font-size: 1.5rem;">Vivez des moment intenses</p>

</div>
  <section style="padding: 10px 30px; max-width: 1200px; margin: auto;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">

      <!-- Événement 1 -->
      <div class="event-card">
        <img src="images/event1.avif" alt="Soirée des célibataires">
        <div class="card-content ">
          <h3>Soirée Célibataires - Cotonou</h3>
          <p>Un moment de détente autour de jeux, discussions et cocktails pour créer des liens naturellement.</p>
          <button><a href="even/soiree.php" style="text-decoration: none; color: white;">Consulter</a></button>
          <button><a href="even/soires.php" style="text-decoration: none; color: white;">Ajouter un évènement (Soirée)</a></button>
        </div>
      </div>

      <!-- Événement 2 -->
      <div class="event-card">
        <img src="images/event2.avif" alt="Atelier Confiance en soi">
        <div class="card-content">
          <h3>Atelier Confiance & Séduction</h3>
          <p>Des coachs en relations partagent leurs conseils pour renforcer l’estime de soi et séduire avec sincérité.</p>
          <button><a href="even/ateliers.php" style="text-decoration: none; color: white;">Consulter</a></button>
          <button><a href="even/ateliee.php" style="text-decoration: none; color: white;">Ajouter un évènement (Atelier ou Séance de coaching)</a></button>
        </div>
      </div>

      <!-- Événement 3 -->
      <div class="event-card">
        <img src="images/event3.avif" alt="Rencontres virtuelles">
        <div class="card-content">
          <h3>Rencontres Virtuelles</h3>
          <p>Depuis chez vous, rencontrez d'autres membres via des salons vidéo thématiques et animés en direct.</p>
          <button><a href="register.php" style="text-decoration: none; color: white;">Découvrir</a></button>
        </div>
      </div>

    </div></div>

  </section>
  <!-- Animation script -->
<section style="background-color: rgb(253, 253, 253); padding: 30px 20px; text-align: center;">
  <h2 style="color: #ff5a5f; font-weight: bold;">Retrouvez les événements</h2>
 <!-- Barre de recherche -->
  <div style="margin-top: 20px; margin-bottom: 20px;">
<form action="even/even_pays.php" method="GET" class="recherche-container">
      <input type="text" name="pays" class="recherche-input" placeholder="Recherchez un pays (ex: France, Canada...)">
      <button type="submit" class="recherche-btn">&#128269;</button>
    </form>
<!-- Boutons de pays -->
    <!-- Container Responsive -->
<div class="container mt-4">
  <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-2">
<div class="col">
      <a href="even/even_pays.php?pays=Bénin" class="btn btn-light w-100 small border pays-bouton">🇧🇯 Événements en Bénin</a>
    </div>
<div class="col">
      <a href="even/even_pays.php?pays=Togo" class="btn btn-light w-100 small border pays-bouton">🇹🇬 Événements au Togo</a>
    </div>

    <div class="col">
      <a href="even/even_pays.php?pays=Côte d'Ivoire" class="btn btn-light w-100 small border pays-bouton">🇨🇮 Événements en Côte d'Ivoire</a>
    </div>

    <div class="col">
      <a href="even/even_pays.php?pays=Sénégal" class="btn btn-light w-100 small border pays-bouton">🇸🇳 Événements au Sénégal</a>
    </div>

    <div class="col">
      <a href="even/even_pays.php?pays=France" class="btn btn-light w-100 small border pays-bouton">🇫🇷 Événements en France</a>
    </div>

    <div class="col">
      <a href="even/even_pays.php?pays=Canada" class="btn btn-light w-100 small border pays-bouton">🇨🇦 Événements au Canada</a>
    </div>

  </div>
</div>

  </div>
</section>

<section >
  <h2 style="text-align: center; color: #ff5a5f; font-size: 2.5rem; font-weight: bold;">Rencontrez des célibataires partout</h2>
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; max-width: 1200px; margin: auto; margin-top: 40px;">

    <!-- Pays 1 -->
    <div class="card-rencontre-pays" style="background-image: url('images/benin.jpeg');">
      <div class="content">
        <h3>Bénin</h3>
        <p>Découvrez les événements pour célibataires dans plusieurs villes du Bénin. Soirées conviviales, ateliers, dîners et plus encore.</p>
        <a href="even/even_pays.php?pays=Bénin">Consulter</a>
        </div>
    </div>
        <!-- Pays 2 -->
        <div class="card-rencontre-pays" style="background-image: url('images/togo.jpeg');">
          <div class="content">
          <h3>Togo</h3>
          <p>Participez à des activités de rencontre à Lomé et dans tout le Togo, dans une ambiance détendue et propice à la connexion.</p>
          <a href="even/even_pays.php?pays=Togo">Consulter</a>
          </div>
    </div>

        <!-- Pays 3 -->
        <div class="card-rencontre-pays" style="background-image: url('images/cote ivoire.jpeg');">
          <div class="content">
          <h3>Côte d'Ivoire</h3>
          <p>Abidjan et d'autres villes vous accueillent pour des événements dédiés aux célibataires modernes, ouverts et curieux.</p>
          <a href="even/even_pays.php?pays=Côte d'Ivoire">Consulter</a>

        </div>
    </div>

        <!-- Pays 4 -->
        <div class="card-rencontre-pays" style="background-image: url('images/france.jpeg');">
          <div class="content">
          <h3>France</h3>
          <p>Rencontrez des célibataires à Paris, Lyon, Marseille... dans des soirées, jeux de rôle, pique-niques et événements thématiques.</p>
          <a href="even/even_pays.php?pays=France">Consulter</a>

        </div>
    </div>

        <!-- Pays 5 -->
        <div class="card-rencontre-pays" style="background-image: url('images/senegal.jpeg');">
          <div class="content">
          <h3>Sénégal</h3>
          <p>De Dakar à Saint-Louis, vivez des rencontres authentiques à travers nos programmes de sorties pour célibataires.</p>
          <a href="even/even_pays.php?pays=Sénégal">Consulter</a>

        </div>
    </div>

        <!-- Pays 6 -->
        <div class="card-rencontre-pays" style="background-image: url('images/canada.jpeg');">
          <div class="content">
            <h3>Canada</h3>
            <p>À Montréal, Toronto ou Québec, rejoignez une communauté de célibataires lors d’événements innovants et multiculturels.</p>
            
            <a href="een/even_pays.php?pays=Canada">Consulter</a>

        </div>
    </div>
  </div>

  <a href="even/tous_pays.php" class="btn btn-outline-danger mt-4">Voir tous les pays</a>

  <a href="even/evenpp.php" class="btn btn-outline-danger mt-4" style="text-decoration: none; color: white; border: none; background-color: #ff5a5f;
      font-weight: bold; border-radius: 15px; padding: 15px;">Ajouter un évènement dans un pays
  </a>


</section>

<style>
  .card-rencontre-pays {
  position: relative;
  height: 400px;
  background-size: cover;
  background-position: center;
  border-radius: 15px;
  overflow: hidden;
  display: flex;
  align-items: flex-end;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-rencontre-pays:hover {
  transform: scale(1.03);
  box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

/* .card-rencontre-pays img {
  width: 100%;
  height: 200px;
  object-fit: cover;
} */

.card-rencontre-pays h3 {
  font-size: 1.5rem;
  margin-top: 15px;
  font-weight: bold
}

.card-rencontre-pays p {
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 20px;
}

.card-rencontre-pays .content {
  background: rgba(32, 30, 30, 0.6);
color: white;
padding: 15px;
width: 100%;
text-align: left;
font-weight: bold
}

.card-rencontre-pays .content a {
background: rgba(243, 240, 250, 0.97);
color: #ff5a5f;
padding: 10px;
font-weight: bold;
text-decoration: none;
}

.card-rencontre-pays .content a:hover {
background: #ff5a5f;
color:rgb(245, 246, 250); 
}

</style>
 <style>
    
    .event-card {
      background-color: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      animation: fadeInUp 1s ease forwards;
      opacity: 0;
    }

    .event-card:hover {
      transform: scale(1.05);
      box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .event-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .card-content {
      padding: 20px;
      background-color:rgb(235, 235, 240);
    }

    .card-content h3 {
      color: #ff5a5f;
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    .card-content p {
      font-size: 1rem;
      color: black;
    }

    .card-content button {
      margin-top: 15px;
      padding: 10px 20px;
      border: none;
      border-radius: 25px;
      background-color: #ff5a5f;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(40px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .event-card:nth-child(1) {
      animation-delay: 0.2s;
    }

    .event-card:nth-child(2) {
      animation-delay: 0.4s;
    }

    .event-card:nth-child(3) {
      animation-delay: 0.6s;
    }
  </style>
      <style>
      .recherche-container {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 600px;
        margin: auto;
        gap: 10px;
      }

      .recherche-input {
        padding: 12px 20px;
        border-radius: 50px;
        border: 1px solid #ccc;
        width: 100%;
        font-size: 16px;
      }

      .recherche-btn {
        background-color: #ff5a5f;
        color: white;
        border: none;
        padding: 12px 18px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease, transform 0.2s ease;
      }

      .recherche-btn:hover {
        background-color: #e0484d;
        transform: scale(1.05);
      }

      .pays-bouton {
        background-color: rgb(238, 238, 241);
        color: black;
        border: none;
        border-radius: 50px;
        padding: 20px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      .pays-bouton:hover {
        background-color: rgb(213, 213, 245);
        transform: scale(1.05);
      }
    </style>
<!-- Inclusion de Bootstrap JS et CSS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

<?php include 'foooter.php'; ?>