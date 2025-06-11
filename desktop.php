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
  <style>
    body {
    font-family: 'Segoe UI', sans-serif;
    box-sizing: border-box;
    overflow-x: hidden; /* Empêche le débordement horizontal */

}

    .hero {
      background-color: #f8f9fa;
      padding: 40px 20px;
      text-align: center;
    }
    .form-box {
      background: rgb(248, 235, 236);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
   
    .gender-options label {
      margin-right: 15px;
    }

    .form-box {
    background:rgb(248, 235, 236);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    max-width: 380px;
    margin: 20px auto;
    margin-top: -60px;
}

.form-box h2 {
    font-size: 18px;
    margin-bottom: 10px;
    color: black;
}

.gender-options {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    font-size: 24px;
}

.conditions {
    font-size: 13px;
    margin-bottom: 20px;
}

.conditions a {
    color:rgb(11, 12, 12);
    text-decoration: none;
  }


/* RESPONSIVE : petits écrans */
@media (max-width: 768px) {
  .hero {
    flex-direction: column;
    gap: 30px;
    padding: 10px;
    margin-top: -20px
  }

  
  .typewriter {
  font-size: 0.95rem; /* Taille pour grand écran */
  color: #FF5A5F;
  font-weight: bold;
}

/* Sur petit écran, réduire la taille et simuler un h3 */
@media (max-width: 768px) {
  .typewriter {
    font-size: 1rem; /* taille proche de h3 */
  }
}

  .btn-group {
    flex-direction: column;
    gap: 30px
  }
  
  .btn-group .btn-custom {
    width: 100%;
  }
}

.hero h2 {
    font-size: 2rem;
    font-weight: bold;
    color: #FF5A5F;
}
.hero p {
    font-size: 1rem;
    max-width: 500px;
    margin-bottom: 10px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
  .bblove-container {
    flex-direction: column;
    padding: 20px;
  }

  .bblove-text,
  .bblove-image {
    flex: 1 1 100%;
    text-align: center;
  }

  .bblove-title {
    font-size: 1.8rem;
    top: 0;
  }

  .love-card h2 {
    font-size: 1.5rem;
  }

  .love-card p {
    font-size: 1rem;
  }

  .cta-link {
    font-size: 1.2rem;
  }

  .icon-container {
    flex-wrap: wrap;
    gap: 15px;
    font-size: 1.5rem;
  }
}

/* Responsive */
@media (max-width: 768px) {
  .loving-title {
    font-size: 2rem;
  }

  .loving-icons {
    flex-direction: column;
    align-items: center;
    padding: 0 20px 40px;
  }

  .icon-block {
    max-width: 100%;
  }

  .text-content h2 {
    font-size: 1.6rem;
  }

  .text-content p {
    font-size: 1rem;
  }

  .cta-link {
    font-size: 1.2rem;
  }

  .icon-heart {
    flex-wrap: wrap;
    font-size: 1.5rem;
  }
}


/* Responsive mobile */
@media (max-width: 600px) {
  .bblove-card {
    padding: 20px;
  }
}

.rencontre-title {
    text-align:center;
    color: #FF5A5F;
    font-size: 2rem;
    font-weight: bold;
}

.bblove-hero {
  position: relative;
  width: 80%;
  height: 50vh;
  background: url('images/logo1.png') no-repeat center center;
  background-size: cover;
  display: flex;
  align-items: center;
  justify-content: center;
}

.bblove-overlay {
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.4); /* fond transparent blanc */
  display: flex;
  align-items: center;
  justify-content: center;
}

.bblove-card {
  background: rgba(255, 255, 255, 0.9); /* carte plus visible mais légèrement transparente */
  padding: 15px;
  border-radius: 15px;
  max-width: 600px;
  text-align: center;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

.bblove-text p {
  font-size: 1.2rem;
  color: #333;
  margin-bottom: 1rem;
}


/* ✅ Media Query pour les petits écrans */
@media (max-width: 768px) {
  .bblove-card {
    padding: 10px;
  }

  .bblove-text p {
    font-size: 1rem;
  }
}

@media (max-width: 480px) {
  .bblove-text p {
    font-size: 0.95rem;
  }

  .bblove-card {
    padding: 10px;
  }
}

@media (max-width: 768px) {
  .form-box {
    display: none;
  }
}

  </style>
</head>
<body>
  
<!-- Hero Section -->
  <div class="hero">
    <!-- Bloc formulaire à gauche -->
    <div class="hero-form">
      <div class="form-box">
          <h2>Je suis</h2>
          <div class="gender-options">
              <label><input type="radio" name="gender" value="femme"> 👩</label>
              <label><input type="radio" name="gender" value="homme"> 👨</label>
          </div>

          <h2>Je cherche</h2>
          <div class="gender-options">
              <label><input type="radio" name="search" value="homme"> 👨</label>
              <label><input type="radio" name="search" value="femme"> 👩</label>
          </div>

          <div class="conditions">
              <label for="accept" style="color:rgb(14, 4, 5); gap: 10px;">
                  <input type="checkbox" id="accept" />   J’ai lu et j’accepte les <a href="privacy_policy.php" style="color: blue;">politiques de confidentialités</a>.
              </label>
          </div>

            <button class="btn-custom" onclick="window.location.href='register.php'">Je m'inscris maintenant</button>
      </div>
    </div>

    <h2  style="color: #ff5a5f;">Rencontrez l'amour au cœur du digital</h2>

    <p class="fade-up" style="color: white;">Créez votre profil, explorez des profils compatibles, échangez en toute sécurité, et trouvez celui ou celle qui vous correspond.</p>

    <div class="btn-group" style="display: flex; gap: 30px;">
      <a href="register.php" class=" btn-custom">Inscription / Connexion</a>
      <a href="a propos.php" class=" btn-custom">En savoir plus</a>
    </div>
<br><br>
  </div>

<section class="bblove-hero">
  <div class="bblove-overlay">
    <div class="bblove-card">
      <div class="bblove-text">
        <p>
          BBLove est votre espace de rencontre authentique, moderne pour échanger avec 
          des personnes qui partagent vos valeurs et votre vision de l'amour.
        </p>
        <p>
          ❤️ <em>BBLove, c’est plus qu’un site de rencontres : c’est un lieu de connexion humaine, de respect
             où chaque histoire a sa chance de naître et de grandir.</em>
        </p>
      </div>
    </div>
  </div>
</section>


<div class="separator"></div>

<section class="love-tech-section">
  <div class="overlay">
    <div class="love-card">
      <h2>La rencontre en ligne simplifiée avec <span style="color: #FF5A5F;">BBLove</span></h2>
       <p>
      BBLOVE est une plateforme de rencontre moderne qui facilite les connexions sincères et durables. Grâce à des 
      conseils adaptés, un environnement sécurisé et des fonctionnalités intuitives, BBLOVE accompagne chaque célibataire 
      dans sa quête de l'amour véritable. <a href="site.php" style="color: red; text-decoration: none; font-size: 1.5rem; font-weight: bold;">Cliquez-ici</a>
    </p>

      <div class="icon-container">
        <i class="fas fa-laptop"></i>
        <i class="fas fa-users"></i>
        <i class="fas fa-heart"></i>
      </div>
    </div>
  </div>
</section>


    <div class="separator"></div>

  <section class="loving-section">
  <h3 class="loving-title">Faites des rencontres sur <span style="color: #FF5A5F; padding: 10px;">BBLove</span></h3>
  <div class="loving-icons">
    <div class="icon-block">
      <img src="images/chat-icon-red.avif" alt="Conversations" />
      <p>Commencer de nouvelles conversations</p>
    </div>
    <div class="icon-block">
      <img src="images/couple-icon-red.jpg" alt="Histoires d’amour" />
      <p>Vivez de belles aventures sont écrites</p>
    </div>
    <div class="icon-block">
      <img src="images/photo-icon-red.avif" alt="Partenaire parfait" />
      <p>Trouver le partenaire ou la partenaire parfait(e)</p>
    </div>
  </div>
</section>

<div class="separator"></div>

<section class="bg-section parallax">
  <div class="overlay-card fade-in">
    <div class="text-content">
      <h2>Chaque grande histoire commence par une rencontre</h2>
       <p>
        Sur BBLove, chaque profil cache une âme en quête d’amour sincère.
        Ici, naissent des histoires inoubliables, tissées de regards échangés,
        de mots doux et de promesses murmurées. Ose écrire ton chapitre. 
        <a href="site.php" style="color: red; text-decoration: none; font-size: 1.5rem; font-weight: bold;">Cliquez-ici</a>
      </p>
      <div class="icon-heart">
        <i class="fas fa-laptop"></i>
        <i class="fas fa-heart heart-on-laptop"></i>
        <i class="fas fa-heart" style="margin-left: 8px; color: red;"></i>
      </div>
    </div>
  </div>
</section>


  <div class="separator"></div>

  <h2 style="text-align:center; color: #FF5A5F; font-size: 2rem; font-weight: bold;">Ce que nous offrons</h2>
 <section>
  <div class="features-grid">

    <!-- Feature 1 -->
    <a href="register.php" class="feature-card">
      <img src="img/profil.png" alt="Profil personnalisé">
      <h3><i class="fas fa-user"></i> Profil personnalisé</h3>
      <p>Créez un profil détaillé qui vous ressemble avec vos informations et préférences.</p>
    </a>

    <!-- Feature 2 -->
    <a href="register.php" class="feature-card">
      <img src="img/recherche.avif" alt="Recherche avancée" >
      <h3><i class="fas fa-search"></i> Recherche avancée</h3>
      <p>Trouvez des profils selon vos critères : âge, région, intérêts, etc.</p>
    </a>

    <!-- Feature 3 -->
    <a href="register.php" class="feature-card">
      <img src="img/message.avif" alt="Messagerie sécurisée">
      <h3><i class="fas fa-comments"></i> Messagerie sécurisée</h3>
      <p>Discutez en toute sécurité grâce à notre messagerie interne privée.</p>
    </a>

    <!-- Feature 4 -->
    <a href="register.php" class="feature-card">
      <img src="img/match.jpg" alt="Matchmaking intelligent">
      <h3><i class="fas fa-heart"></i> Matchmaking intelligent</h3>
      <p>Recevez des suggestions basées sur vos affinités et préférences.</p>
    </a>

    <!-- Feature 5 -->
    <a href="even.php" class="feature-card">
      <img src="img/evenements.avif" alt="Événements virtuels">
      <h3><i class="fas fa-video"></i> Événements virtuels</h3>
      <p>Participez à des soirées rencontres et discussions thématiques en ligne.</p>
    </a>

    <!-- Feature: Surprise -->
    <a href="surprise.php" class="feature-card">
      <img src="img/surprise.avif" alt="Faire une surprise">
      <h3><i class="fas fa-gift"></i> Surprise</h3>
      <p>Faites un geste tendre, offrez un cadeau ou surprenez un proche en toute simplicité.</p>
    </a>


  </div>
</section>

<div class="separator"></div>

<section class="matchmaking-section">
  <div class="matchmaking-card">
    <h2>Le pouvoir du Matchmaking</h2>
    <p>
      Grâce à notre technologie de compatibilité, BBLove connecte des personnes partageant des valeurs, des rêves et des personnalités complémentaires. 
      Nous croyons que l’amour véritable repose sur une harmonie naturelle. 
      Découvrez des profils qui vous correspondent vraiment, au-delà des apparences.<a href="site.php" style="color: red; text-decoration: none; font-size: 1.5rem; font-weight: bold;">Cliquez-ici</a>
    </p>
  </div>
</section>

<div class="separator"></div>


<section class="bblove-conseils">
  <h3 class="conseils-title">
    Nos conseils pour des rencontre en ligne
    <span class="underline"></span>
  </h3>
  <div class="conseils-grid">
    <div class="conseil-item">
      <img src="img/img2.avif" alt="Couple heureux" class="conseil-image">
      <h3>Pourquoi choisir un site de rencontre payant ?</h3>
      <p>
        Un site de rencontre payant et sérieux offre plus de sécurité qu’un site de rencontre gratuit.<br>
        Découvrez ses avantages ici. <a href="site.php">Lire l’article</a>
      </p>
    </div>
    <div class="conseil-item">
      <img src="img/img3.avif" alt="Couple amoureux" class="conseil-image">
      <h3>Comment faire une rencontre amoureuse ?</h3>
      <p>
        Et vous, quelle sera l’histoire de votre rencontre ?<br>
        Suivez les conseils de nos experts pour trouver votre âme sœur. <a href="site.php">Lire l’article</a>
      </p>
    </div>
    <div class="conseil-item">
      <img src="img/img4.jpg" alt="Couple senior" class="conseil-image">
      <h3>Les rencontres séniors sur BBLove</h3>
      <p>
        Presqu’un Français sur quatre a plus de 60 ans et nombreux sont ces seniors qui sont à la recherche de l’amour. 
        <a href="site.php">Lire l’article</a>
      </p>
    </div>
  </div>
</section>


<div class="separator"></div>

    <section class="notif-section">
  <div class="notif-container">
  <div class="bblove-card">
    <div class="notif-text">
      <h2 style=" font-size: 1.5rem; font-weight: bold;">Nos suggestions et recommandatons pour une bonne rencontre en ligne.</h2>
            <hr class="footer-separator">
      <p>
        Chaque jour, vous recevrez par e-mail et via nos notifications push des sélections personnalisées
        de profils de célibataires. <br> 
        Découvrez nos recommandations, où que vous soyez… parce que ce serait dommage de passer à côté d’un coup de cœur !
        <a href="site.php" style="color: red; text-decoration: none; font-size: 1.5rem; font-weight: bold;">Cliquez-ici</a>
      </p>
    </div>
  </div>
    <div class="notif-image">
      <img src="images/notification-phone.jpg" alt="Notification de profils">
    </div>
  </div>
</section>

<div class="separator"></div>

<section class="profil-section"
style=" background-image: url('https://img.huffingtonpost.com/asset/6711135c1d00001c004d0089.jpeg?ops=scalefit_720_noupscale&format=webp'); /* Remplace par ton image */
  background-size: cover;
  background-position: center;
  height: 90vh;
  width: 100vw;
  position: relative;
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  overflow: hidden;">
  <div class="profil-card">
    <h2>La création du profil</h2>
    <p>
      La sincérité et l’authenticité sont les gages d’une rencontre réussie ; il est donc important que votre profil reflète au mieux votre personnalité et qu’il soit soigneusement rempli. 
      C’est le premier contact avec les autres membres et il constitue la base des premiers échanges. 
      Un profil attractif avec une photo a plus de chance d’être contacté qu’un profil incomplet. 
      Les fonctionnalités de BBLove permettent de donner toutes les informations que vous désirez. 
      Découvrez comment remplir votre profil. <a href="register.php" style="color: #ff5a5f; text-decoration: none; font-size: 1.5rem; font-weight: bold;">Cliquez-ici</a>

    </p>
  </div>
</section>


<div class="separator"></div>

<section class="profiles-section">
  <h2 style="text-align:center; color: #FF5A5F; font-size: 2rem; font-weight: bold;">
    Explorez des profils compatibles
  </h2>

  <div class="profiles-grid">
    <!-- Profil 1 -->
    <div class="profile-card">
      <img src="img/avatar1.avif" alt="Profil de Sophie" class="profile-image">
      <div class="profile-name">Sophie, 29 ans</div>
      <div class="profile-bio">Recherche une relation sincère et stable, basée sur la communication.</div>
    </div>

    <!-- Profil 2 -->
    <div class="profile-card">
      <img src="img/avatar2.avif" alt="Profil de Alex" class="profile-image">
      <div class="profile-name">Alex, 32 ans</div>
      <div class="profile-bio">Souhaite trouver une âme sœur passionnée par les voyages et la culture.</div>
    </div>

    <!-- Profil 3 -->
    <div class="profile-card">
      <img src="img/avatar3.avif" alt="Profil de Jade" class="profile-image">
      <div class="profile-name">Jade, 26 ans</div>
      <div class="profile-bio">Cherche quelqu’un de drôle et attentionné pour construire quelque chose de vrai.</div>
    </div>

    <!-- Profil 4 -->
    <div class="profile-card">
      <img src="img/avatar4.avif" alt="Profil de Thomas" class="profile-image">
      <div class="profile-name">Thomas, 35 ans</div>
      <div class="profile-bio">Envie de complicité et de partage dans une relation authentique.</div>
    </div>

    <!-- Profil 5 -->
    <div class="profile-card">
      <img src="img/avatar5.avif" alt="Profil de Lina" class="profile-image">
      <div class="profile-name">Lina, 30 ans</div>
      <div class="profile-bio">Rechercher l'amour véritable, avec bienveillance et humour.</div>
    </div>
    
    <!-- Profil 6 -->
    <div class="profile-card">
      <img src="img/avatar6.avif" alt="Profil de Jade" class="profile-image">
      <div class="profile-name">Alain, 26 ans</div>
      <div class="profile-bio">Cherche quelqu’un de drôle et attentionné pour construire quelque chose de vrai.</div>
    </div>
  </div>
</section>

      <div style="text-align: center; padding: 15px;">
        <a href="register.php" class=" btn-custom">Voir plus</a>
      </div>  

<div class="separator"></div>

<section class="nouveautes-section">
  <h2 class="nouveautes-title">Nouveautés BBLove</h2>
  <div class="nouveautes-grid">
    <div class="nouveaute-item">
      <img src="img/appartement.avif" alt="Séduire avec son appartement">
      <h3>Séduire avec son appartement</h3>
      <p>La décoration de votre domicile peut en dire long sur vous. Découvrez comment séduire grâce à votre appartement.</p>
      <a href="https://africa-location.com/">Voir le site</a>
    </div>
    <div class="nouveaute-item">
      <img src="img/application.avif" alt="Application iOS">
      <h3>Découvrez l’app BBLove sur iOS</h3>
      <p>Emportez BBLove partout avec vous. Téléchargez notre application pour iPhone dès maintenant.</p>
    </div>
  </div>
</section>


<style>

/* Responsivité mobile */
@media (max-width: 768px) {
  .nouveautes-grid {
    grid-template-columns: 1fr; /* une seule colonne */
  }
  
  .nouveaute-item img {
    width: 100%;       /* images adaptent la largeur */
    height: auto;
    display: block;
  }
}

</style>


<div class="separator"></div>

<section class="app-section">
  <div class="app-content">
    <h2>Faites des rencontres quand vous voulez, où que vous soyez !</h2>
    <div class="store-buttons">
      <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="store-icon"></a>
    </div>
  </div>
</section>


<div class="separator"></div>


<section class="rencontres-section">
  <h2 class="rencontre-title" >Faire des Rencontres dans le Monde</h2>
  <div class="rencontres-grid">

    <!-- Bénin -->
    <div class="rencontre-card" style="background-image: url('images/benin.jpeg');">
      <div class="card-content">
        <h3 style="color: white;">Bénin</h3>
        <p style="color: white;">Découvrez des célibataires à Cotonou, Porto-Novo, Parakou…</p>
        <a href="even/even_pays.php?pays=Bénin" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

    <!-- Côte d'Ivoire -->
    <div class="rencontre-card" style="background-image: url('images/cote ivoire.jpeg');">
      <div class="card-content">
        <h3 style="color: white;">Côte d’Ivoire</h3>
        <p style="color: white;">Rencontrez l’amour à Abidjan, Yamoussoukro et au-delà.</p>
        <a href="even/even_pays.php?pays=Cote d'Ivoire" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

    <!-- Togo -->
    <div class="rencontre-card" style="background-image: url('images/togo.jpg');">
      <div class="card-content">
        <h3 style="color: white;">Togo</h3>
        <p style="color: white;">Faites de belles rencontres à Lomé et dans tout le pays.</p>
        <a href="even/even_pays.php?pays=Togo" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

    <!-- Sénégal -->
    <div class="rencontre-card" style="background-image: url('images/senegal.jpeg');">
      <div class="card-content">
        <h3 style="color: white;">Sénégal</h3>
        <p style="color: white;">Découvrez des profils à Dakar et dans les régions environnantes.</p>
        <a href="even/even_pays.php?pays=Sénégal" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

    <!-- Burkina Faso -->
    <div class="rencontre-card" style="background-image: url('images/burkina.jpeg');">
      <div class="card-content">
        <h3 style="color: white;">Burkina Faso</h3>
        <p style="color: white;">Rencontrez des célibataires à Ouagadougou et ailleurs.</p>
        <a href="even/even_pays.php?pays=Burkina Faso" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

    <!-- France -->
    <div class="rencontre-card" style="background-image: url('images/france.jpeg');">
      <div class="card-content">
        <h3 style="color: white;">France</h3>
        <p style="color: white;">Des opportunités de rencontre partout : Paris, Lyon, Marseille…</p>
        <a href="even/even_pays.php?pays=France" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

    <!-- Canada -->
    <div class="rencontre-card" style="background-image: url('images/canada.jpeg');">
      <div class="card-content">
        <h3 style="color: white;">Canada</h3>
        <p style="color: white;">Voyager dans les merveilles du Canada et trouver votre flamme</p>
        <a href="even/even_pays.php?pays=Canada" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

    <!-- Europe -->
    <div class="rencontre-card" style="background-image: url('images/europe.jpeg');">
      <div class="card-content">
        <h3 style="color: white;">Europe</h3>
        <p style="color: white;">Découvrezl'Europe, uneopportunité de trouver votre moitié</p>
        <a href="even/even_pays.php?pays=Europe" class="btn-rencontrer">Rencontrer</a>
      </div>
    </div>

  </div>
</section>

        

  <div class="separator"></div>

<!-- Section Service Client -->
<section style="position: relative; 
background-image: url('img/service.avif'); 
background-size: cover; 
background-position:
 center; height: 600px;
 display: flex; 
  align-items: flex-start;
  justify-content: flex-end; !">


<div style="
  position: absolute;
  bottom: 30px;
  left: 30px;
  background: rgba(252, 233, 233, 0.2);
  padding: 20px 30px;
  border-radius: 8px;
  color: #000; 
  max-width: 350px;
  text-align: left;
">
  <h2 style="margin-bottom: 10px;">Notre service client</h2>
  <p style="font-size: 1.3rem;">
    Notre service clientèle vous accompagne pendant toutes les étapes de votre recherche sur BBLove. Composée de
     professionnels, notre équipe vous écoute et vous guide avec bienveillance.<a href="contacts.php" style="color: red; text-decoration: none; font-size: 1.5rem; font-weight: bold;">Cliquez-ici</a>
  </p>
</div>

</section>

<!-- Section Protection des données -->
<section style="background: #fff; padding:20px;">
  <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; max-width: 1100px; margin: auto;">
    
    <!-- Image à gauche -->
    <div style="flex: 1 1 300px; display: flex; justify-content: center; ">
      <img src="img/user-avatar.avif" alt="Conseillère"
           style="width: 350px; height: 200px; border-radius: 50%; object-fit: cover;">
    </div>

    <!-- Texte à droite -->
      <div class="bblove-card">
    <div style="flex: 1 1 400px; text-align: center;">
      <h3 style="color: #ff5a5f; font-size: 2rem;">Protection des données</h3>
      <p style="font-size: 1rem; color: black; max-width: 500px;">
        Chez <strong>BBLove</strong>, votre sécurité est au cœur de nos préoccupations. C’est pourquoi chaque donnée est
        traitée avec soin. Vos informations sont protégées et confidentielles.
      </p>
      <div style="font-size: 36px;">🔒</div>
    </div>
  </div>
    
  </div>
</section>

<style>
 
/* ✅ RESPONSIVE MOBILE */
@media (max-width: 768px) {
  .data-text h3 {
    font-size: 1.6rem;
  }

  .data-text p {
    font-size: 1rem;
  }

  .data-icon {
    font-size: 28px;
  }
}
</style>

  <div class="separator"></div>

<section class="temoignages-section">
  <h3 class="temoignages-title">Ce qu'ils disent de BBLove</h3>
  <div class="temoignages-grid">

    <!-- Témoignage 1 -->
    <div class="temoignage-card">
      <p class="temoignage-text">« Grâce à BBLove, j’ai rencontré l’homme de ma vie. Nous vivons ensemble depuis 2 ans maintenant ! »</p>
      <div class="temoignage-user">
        <img src="images/avatar1.avif" alt="Aïcha" />
        <div style="color: black;">
          <strong style="color:rgb(252, 13, 13);">Aïcha</strong><br>
          Londres, Royaume-Unis
        </div>
      </div>
    </div>

    <!-- Témoignage 2 -->
    <div class="temoignage-card">
      <p class="temoignage-text">« Je pensais que l’amour en ligne n’était pas fait pour moi… et puis j’ai découvert BBLove. Un vrai coup de cœur. »</p>
      <div class="temoignage-user">
        <img src="images/avatar2.avif" alt="Charles" />
        <div style="color: black;">
          <strong style="color:rgb(252, 13, 13);">Charles</strong><br>
          Cotonou, Bénin
        </div>
      </div>
    </div>

    <!-- Témoignage 3 -->
    <div class="temoignage-card">
      <p class="temoignage-text">« Ce site est sérieux, sécurisé, et surtout humain. Merci BBLove pour cette belle rencontre ! »</p>
      <div class="temoignage-user">
        <img src="images/avatar3.avif" alt="Mariam" />
        <div style="color: black;">
          <strong style="color:rgb(252, 13, 13);">Mariam</strong><br>
          Dakar, Sénégal
        </div>
      </div>
    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <!--Start of Tawk.to Script-->
<!--<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/682f579ed8556919130118d0/1irseskk4';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
End of Tawk.to Script-->
</body>
<?php include 'foooter.php'; ?>
