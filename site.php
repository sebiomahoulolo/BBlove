<?php include 'navbar.php'; ?>

    <style>
        .sub-menu {
            background-color: #ffe5e7;
            padding: 10px 0;
        }

        .sub-menu a {
            color: #ff5a5f;
            text-decoration: none;
            padding: 10px 15px;
            font-weight: bold;
        }

        .sub-menu a:hover {
            background-color: white;
        }

        section {
            padding: 50px 20px;
            display: none;
            color: black;
        }

        section.active {
            display: block;
        }

         .conseils-rencontre {
    background: #fff;
    padding: 60px 20px;
    font-family: 'Segoe UI', sans-serif;
    color: #333;
  }

 /* Hero section */
.hero-conseil {
  position: relative;
  background-image: url('img/rencontre-couple.avif'); /* Remplace par ton image */
  background-size: cover;
  background-position: center;
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 40px 20px;
}

.hero-overlay {
  background-color: rgba(0, 0, 0, 0.6); /* Fond noir transparent */
  padding: 40px 30px;
  border-radius: 20px;
  color: #fff;
  max-width: 850px;
  backdrop-filter: blur(4px);
  animation: fadeInUp 1.5s ease-out both;
}

.hero-overlay h2 {
  font-size: 40px;
  color: #ff5a5f;
  margin-bottom: 20px;
}

.hero-overlay p {
  font-size: 18px;
  margin-bottom: 15px;
  line-height: 1.6;
}

/* Animation douce */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .hero-overlay h2 {
    font-size: 28px;
  }

  .hero-overlay p {
    font-size: 16px;
  }
}


  .conseils-rencontre h2 {
    text-align: center;
    color: #ff5a5f;
    font-size: 36px;
    margin-bottom: 20px;
  }

  .conseils-rencontre p.intro {
    text-align: center;
    font-size: 18px;
    max-width: 800px;
    margin: 0 auto 50px;
    color: #666;
  }

  .conseil-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
  }

  .conseil-item {
    background: #fdfdfd;
    border: 1px solid #eee;
    border-radius: 16px;
    padding: 25px;
    max-width: 350px;
    flex: 1 1 300px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .conseil-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
  }

  .conseil-item h3 {
    color: #ff5a5f;
    font-size: 22px;
    margin-bottom: 15px;
  }

  .conseil-item p {
    font-size: 15px;
    line-height: 1.6;
    color: #444;
  }

  @media (max-width: 768px) {
  .hero-conseils {
    height: auto;
    padding: 60px 0;
  }

  .hero-overlay {
    padding: 30px 15px;
  }
}

/* Hero Vie de couple */
.hero-vie {
  position: relative;
  background-image: url('img/vie-couple.avif'); /* Remplace par ton image */
  background-size: cover;
  background-position: center;
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 40px 20px;
}

.hero-overlay-vie {
  background-color: rgba(0, 0, 0, 0.6); /* Fond noir semi-transparent */
  padding: 40px 30px;
  border-radius: 20px;
  color: #fff;
  max-width: 850px;
  backdrop-filter: blur(4px);
  animation: fadeInUp 1.5s ease-out both;
}

.hero-overlay-vie h2 {
  font-size: 40px;
  color: #ff5a5f;
  margin-bottom: 20px;
}

.hero-overlay-vie p {
  font-size: 18px;
  margin-bottom: 15px;
  line-height: 1.6;
}

/* Animation */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .hero-overlay-vie h2 {
    font-size: 28px;
  }

  .hero-overlay-vie p {
    font-size: 16px;
  }
}

.couple-tips {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 25px;
  max-width: 1100px;
  margin: auto;
}

.tip-card {
  background: #fafafa;
  padding: 25px;
  border-radius: 16px;
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.tip-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
}

.tip-card i {
  font-size: 32px;
  color: #ff5a5f;
  margin-bottom: 15px;
}

.tip-card h3 {
  font-size: 20px;
  margin-bottom: 10px;
  color: #222;
}

.tip-card p {
  font-size: 15px;
  color: #555;
  line-height: 1.5;
}

/* Responsive */
@media (max-width: 600px) {
  .couple-section h2 {
    font-size: 28px;
  }

  .tip-card {
    padding: 20px;
  }
}

/* Hero Section Rupture */
.hero-rupture {
  background-image: url('img/coeur.avif'); /* Remplace par ton image réelle */
  background-size: cover;
  background-position: center;
  height: 100vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.overlay-rupture {
  background-color: rgba(255, 255, 255, 0.75); /* Fond semi-transparent */
  padding: 40px;
  border-radius: 12px;
  max-width: 800px;
  text-align: center;
  backdrop-filter: blur(5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.overlay-rupture h2 {
  font-size: 36px;
  color: #ff5a5f;
  margin-bottom: 20px;
}

.overlay-rupture p {
  font-size: 18px;
  color: #333;
  line-height: 1.6;
}

.overlay-rupture .intro {
  margin-top: 15px;
  font-weight: 500;
  color: #444;
}

/* Responsive */
@media (max-width: 768px) {
  .hero-rupture {
    height: auto;
    padding: 60px 20px;
  }

  .overlay-rupture {
    padding: 25px;
  }

  .overlay-rupture h2 {
    font-size: 28px;
  }

  .overlay-rupture p {
    font-size: 16px;
  }
}


.points-rupture {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  text-align: left;
}

.rupture-item {
  background-color: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
}

.rupture-item:hover {
  transform: translateY(-5px);
}

.rupture-item h3 {
  color: #ff5a5f;
  font-size: 20px;
  margin-bottom: 10px;
}

.rupture-item p {
  color: #333;
  font-size: 16px;
  line-height: 1.6;
}

.btn-rupture {
  display: inline-block;
  background-color: #ff5a5f;
  color: white;
  padding: 12px 25px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 6px 12px rgba(255, 90, 95, 0.3);
  transition: background-color 0.3s ease;
}

.btn-rupture:hover {
  background-color: #e14b50;
}

/* Responsive */
@media (max-width: 768px) {
  .title-rupture {
    font-size: 28px;
  }

  .intro-rupture {
    font-size: 16px;
  }
}

.hero-sexualite {
  position: relative;
  background-image: url('img/sexualitz.avif'); /* Remplace par ton image réelle */
  background-size: cover;
  background-position: center;
  height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.overlay-sexualite {
  background-color: rgba(0, 0, 0, 0.5); /* Fond transparent foncé */
  padding: 40px 20px;
  border-radius: 16px;
  max-width: 800px;
  margin: auto;
}

.overlay-sexualite h2 {
  color: #ff5a5f;
  font-size: 40px;
  margin-bottom: 20px;
}

.overlay-sexualite p {
  color: #fff;
  font-size: 18px;
  line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
  .overlay-sexualite h2 {
    font-size: 28px;
  }

  .overlay-sexualite p {
    font-size: 16px;
  }

  .hero-sexualite {
    height: auto;
    padding: 60px 10px;
  }
}

.points-sexualite {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  text-align: left;
}

.sexualite-item {
  background-color: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
}

.sexualite-item:hover {
  transform: translateY(-5px);
}

.sexualite-item h3 {
  color: #ff5a5f;
  font-size: 20px;
  margin-bottom: 10px;
}

.sexualite-item p {
  color: #333;
  font-size: 16px;
  line-height: 1.6;
}

.btn-sexualite {
  display: inline-block;
  background-color: #ff5a5f;
  color: white;
  padding: 12px 25px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 6px 12px rgba(255, 90, 95, 0.3);
  transition: background-color 0.3s ease;
}

.btn-sexualite:hover {
  background-color: #e14b50;
}

/* Responsive */
@media (max-width: 768px) {
  .title-sexualite {
    font-size: 28px;
  }

  .intro-sexualite {
    font-size: 16px;
  }
}.hero-romantisme {
  position: relative;
  background-image: url('img/romantisme.avif'); /* Remplace avec ton image */
  background-size: cover;
  background-position: center;
  height: 400px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.overlay-romantisme {
  background-color: rgba(255, 255, 255, 0.8); /* Fond semi-transparent blanc */
  padding: 40px;
  border-radius: 12px;
  text-align: center;
  max-width: 800px;
  margin: 0 20px;
}

.overlay-romantisme h2 {
  color: #ff5a5f;
  font-size: 36px;
  margin-bottom: 15px;
}

.overlay-romantisme p {
  font-size: 18px;
  color: #333;
}

@media (max-width: 768px) {
  .hero-romantisme {
    height: auto;
    padding: 60px 20px;
  }

  .overlay-romantisme h2 {
    font-size: 28px;
  }

  .overlay-romantisme p {
    font-size: 16px;
  }
}

.romantisme-points {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  text-align: left;
}

.romantisme-item {
  background-color: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
}

.romantisme-item:hover {
  transform: translateY(-5px);
}

.romantisme-item h3 {
  color: #ff5a5f;
  font-size: 20px;
  margin-bottom: 10px;
}

.romantisme-item p {
  color: #333;
  font-size: 16px;
  line-height: 1.6;
}

.btn-romantisme {
  display: inline-block;
  background-color: #ff5a5f;
  color: white;
  padding: 12px 25px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 6px 12px rgba(255, 90, 95, 0.3);
  transition: background-color 0.3s ease;
}

.btn-romantisme:hover {
  background-color: #e14b50;
}

/* Responsive */
@media (max-width: 768px) {
  .title-romantisme {
    font-size: 28px;
  }

  .intro-romantisme {
    font-size: 16px;
  }
}

.hero-coeurs {
  background-image: url('img/rupture.avif'); /* Remplace par le vrai chemin de ton image */
  background-size: cover;
  background-position: center;
  height: 70vh;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.overlay-coeurs {
  background: rgba(0, 0, 0, 0.5); /* fond semi-transparent */
  padding: 40px;
  border-radius: 15px;
  max-width: 700px;
}

.overlay-coeurs h2 {
  color: #ff5a5f;
  font-size: 36px;
  margin-bottom: 15px;
}

.overlay-coeurs p {
  color: #fff;
  font-size: 18px;
  line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
  .overlay-coeurs {
    padding: 25px;
  }

  .overlay-coeurs h2 {
    font-size: 28px;
  }

  .overlay-coeurs p {
    font-size: 16px;
  }
}

.points-coeurs {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  text-align: left;
}

.coeur-item {
  background-color: #ffffff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
}

.coeur-item:hover {
  transform: translateY(-5px);
}

.coeur-item h3 {
  color: #ff5a5f;
  font-size: 20px;
  margin-bottom: 10px;
}

.coeur-item p {
  color: #333;
  font-size: 16px;
  line-height: 1.6;
}

.btn-coeurs {
  display: inline-block;
  background-color: #ff5a5f;
  color: white;
  padding: 12px 25px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 6px 12px rgba(255, 90, 95, 0.3);
  transition: background-color 0.3s ease;
}

.btn-coeurs:hover {
  background-color: #e14b50;
}

/* Responsive */
@media (max-width: 768px) {
  .title-coeurs {
    font-size: 28px;
  }

  .intro-coeurs {
    font-size: 16px;
  }
}

/* Hero Histoires d'amour */
.hero-histoire {
  position: relative;
  background-image: url('img/amour.jpg'); /* Remplace par ton image */
  background-size: cover;
  background-position: center;
  height: 70vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.overlay-histoire {
  background-color: rgba(255, 255, 255, 0.85); /* fond semi-transparent */
  padding: 40px;
  border-radius: 20px;
  max-width: 700px;
  margin: 0 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.overlay-histoire h2 {
  font-size: 36px;
  color: #ff5a5f;
  margin-bottom: 15px;
}

.overlay-histoire p {
  font-size: 18px;
  color: #333;
}

/* Responsive */
@media (max-width: 768px) {
  .hero-histoire {
    height: 50vh;
  }

  .overlay-histoire h2 {
    font-size: 28px;
  }

  .overlay-histoire p {
    font-size: 16px;
  }
}

.histoire-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 30px;
  text-align: left;
}

.histoire-card {
  background-color: #fff;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
}

.histoire-card:hover {
  transform: translateY(-5px);
}

.histoire-card img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 15px;
}

.histoire-card h3 {
  color: #ff5a5f;
  font-size: 20px;
  margin-bottom: 8px;
}

.histoire-card p {
  color: #333;
  font-size: 16px;
  line-height: 1.6;
}

.cta-container {
  margin-top: 40px;
}

.btn-histoire {
  display: inline-block;
  background-color: #ff5a5f;
  color: white;
  padding: 12px 25px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 6px 12px rgba(255, 90, 95, 0.3);
  transition: background-color 0.3s ease;
}

.btn-histoire:hover {
  background-color: #e14b50;
}

@media (max-width: 768px) {
  .title-histoire {
    font-size: 28px;
  }

  .intro-histoire {
    font-size: 16px;
  }
}
 </style>
</head>
<body>

<!-- Sous-menu -->
<div class="sub-menu sub-menu-grid">
    <a href="#conseil" onclick="showSection('conseil')">Conseil de rencontre</a>
    <a href="#vie" onclick="showSection('vie')">Vie de couple</a>
    <a href="#rupture" onclick="showSection('rupture')">Rupture amoureuse</a>
    <a href="#sexualite" onclick="showSection('sexualite')">Sexualité</a>
    <a href="#romantisme" onclick="showSection('romantisme')">Romantisme</a>
    <a href="#coeurs" onclick="showSection('coeurs')">Cœurs brisés</a>
    <a href="#histoire" onclick="showSection('histoire')">Histoire d'amour</a>
</div>
<style>
  .sub-menu-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 10px;
  padding: 10px;
  text-align: center;
}

.sub-menu-grid a {
  display: block;
  padding: 10px;
  background-color: #FF5A5F;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-size: 14px;
  font-weight: 500;
  transition: background 0.3s ease;
}

.sub-menu-grid a:hover {
  background-color: #e0484e;
}

</style>


<!-- Sections -->
<section id="conseil" class="active">
    <div class="hero-conseil">
        <div class="hero-overlay">
            <h2>Conseils de rencontre</h2>
            <p>Découvrez nos astuces pour faire bonne impression, établir une connexion sincère et réussir vos premiers rendez-vous.</p>
            <p class="intro">Faites la meilleure première impression, créez une vraie connexion, et construisez une relation authentique grâce à nos conseils experts.</p>
        </div>
    </div>

  <iv class="conseil-grid">
    <div class="conseil-item">
      <h3>1. Soyez vous-même</h3>
      <p>L’honnêteté est la clé. Ne jouez pas un rôle. Être authentique attire des personnes qui vous correspondent vraiment.</p>
    </div>

    <div class="conseil-item">
      <h3>2. Soignez votre profil</h3>
      <p>Ajoutez une photo claire et remplissez votre bio avec soin. Montrez vos centres d’intérêt, vos valeurs et ce que vous recherchez vraiment.</p>
    </div>

    <div class="conseil-item">
      <h3>3. Démarrez une vraie conversation</h3>
      <p>Évitez les phrases génériques. Posez des questions ouvertes, montrez de l’intérêt sincère pour la personne, et prenez le temps d’écouter.</p>
    </div>

    <div class="conseil-item">
      <h3>4. Restez bienveillant(e)</h3>
      <p>La rencontre amoureuse demande patience et empathie. Traitez chaque échange avec respect, même si ce n’est pas un match parfait.</p>
    </div>

    <div class="conseil-item">
      <h3>5. Sécurisez vos échanges</h3>
      <p>Utilisez les outils de BBLove pour discuter dans un cadre sécurisé. Ne partagez pas vos données personnelles trop tôt.</p>
    </div>

    <div class="conseil-item">
      <h3>6. Préparez vos rendez-vous</h3>
      <p>Choisissez un lieu où vous vous sentez à l’aise, soyez ponctuel(le) et soyez à l’écoute. Le confort de chacun est essentiel.</p>
    </div>
  </iv>
</section>



<section id="vie"> 
    <div class="hero-vie">
        <div class="hero-overlay-vie">
            <h2>Vie de couple</h2>
            <p>Conseils pour maintenir une relation harmonieuse, gérer les conflits et renforcer votre complicité au quotidien.</p>
            <p class="intro">
            Découvrez comment cultiver l'écoute, le respect et la complicité. Apprenez à communiquer avec bienveillance, à célébrer les moments de joie et à surmonter les épreuves ensemble pour construire un amour durable.
            </p>
        </div>
    </div>

    <div class="couple-tips">
      <div class="tip-card">
        <i class="fas fa-comments"></i>
        <h3>Communication bienveillante</h3>
        <p>Exprimez vos sentiments avec respect. L'écoute active et la transparence renforcent la confiance dans le couple.</p>
      </div>

      <div class="tip-card">
        <i class="fas fa-heart"></i>
        <h3>Moments de qualité</h3>
        <p>Partagez des activités simples et sincères ensemble. Ce sont les petites attentions qui construisent les grands liens.</p>
      </div>

      <div class="tip-card">
        <i class="fas fa-hands-helping"></i>
        <h3>Résolution des conflits</h3>
        <p>Abordez les désaccords avec calme. Trouvez des solutions ensemble sans blâmer, mais en cherchant à comprendre.</p>
      </div>

      <div class="tip-card">
        <i class="fas fa-infinity"></i>
        <h3>Complicité et intimité</h3>
        <p>Renforcez la connexion émotionnelle et physique. Riez ensemble, soutenez-vous et cultivez la tendresse au quotidien.</p>
      </div>
    </div>
</section>



<section id="rupture">
    <div class="hero-rupture">
        <div class="overlay-rupture">
            <h2>Rupture amoureuse</h2>
            <p>Surmontez une séparation difficile avec nos ressources pour retrouver confiance et tourner la page.</p>
            <p class="intro">Nos conseils vous aident à gérer la douleur émotionnelle, reconstruire votre estime de soi et ouvrir la porte à un nouvel avenir plein d’amour et de sérénité.</p>
        </div>
    </div>

      <div class="points-rupture">
      <div class="rupture-item">
        <h3>💔 Accepter la douleur</h3>
        <p>Il est normal de ressentir du chagrin après une rupture. Accordez-vous le droit de souffrir et donnez-vous du temps pour guérir émotionnellement.</p>
      </div>

      <div class="rupture-item">
        <h3>🧠 Se reconnecter à soi</h3>
        <p>Utilisez cette période pour vous recentrer sur vos passions, redécouvrir vos valeurs et travailler votre développement personnel.</p>
      </div>

      <div class="rupture-item">
        <h3>👥 Parler et se faire accompagner</h3>
        <p>Ne restez pas seul(e). Discutez avec vos proches ou faites appel à un coach pour mieux traverser cette période sensible.</p>
      </div>

      <div class="rupture-item">
        <h3>🌅 Tourner la page en douceur</h3>
        <p>Reprendre confiance ne signifie pas oublier, mais avancer avec sérénité. Prenez le temps d'écrire un nouveau chapitre sans précipitation.</p>
      </div>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="rdv_coaching.php" class="btn-rupture">Réserver un coaching personnalisé</a>
    </div>
  </div>
</section>



<section id="sexualite">
    <div class="hero-sexualite">
        <div class="overlay-sexualite">
            <h2>Sexualité</h2>
            <p>Parlez librement de votre intimité et découvrez comment cultiver une vie sexuelle épanouie en couple.</p>
        </div>
    </div>

    <div class="points-sexualite">
      <div class="sexualite-item">
        <h3>💬 Communication ouverte</h3>
        <p>Exprimer ses désirs, ses limites et ses besoins est essentiel pour une sexualité saine et complice.</p>
      </div>

      <div class="sexualite-item">
        <h3>🔥 Redécouvrir le désir</h3>
        <p>La routine peut affaiblir le désir. Explorez de nouvelles façons de vous reconnecter intimement à travers les jeux, les surprises ou les moments à deux.</p>
      </div>

      <div class="sexualite-item">
        <h3>🧠 Connexion émotionnelle</h3>
        <p>Une sexualité épanouie repose aussi sur la tendresse, la confiance et l’écoute émotionnelle mutuelle.</p>
      </div>

      <div class="sexualite-item">
        <h3>🌈 Briser les tabous</h3>
        <p>Chaque couple est unique. Brisez les idées reçues et trouvez votre propre équilibre sexuel sans pression extérieure.</p>
      </div>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="rdv_coaching.php" class="btn-sexualite">Parler à un coach intime</a>
    </div>
</section>


<section id="romantisme" >
    <div class="hero-romantisme">
    <div class="overlay-romantisme">
        <h2>Romantisme</h2>
        <p>Des idées et conseils pour entretenir la flamme de l'amour et surprendre votre partenaire au quotidien.</p>
    </div>
    </div>

        <div class="romantisme-points">
      <div class="romantisme-item">
        <h3>💌 Petites attentions</h3>
        <p>Un mot doux, un message surprise ou un petit geste peuvent illuminer la journée de votre partenaire et nourrir l’amour au quotidien.</p>
      </div>

      <div class="romantisme-item">
        <h3>🌹 Soirées à thème</h3>
        <p>Organisez des dîners romantiques à la maison, des soirées cinéma ou des pique-niques improvisés pour créer des souvenirs inoubliables.</p>
      </div>

      <div class="romantisme-item">
        <h3>🎁 Cadeaux personnalisés</h3>
        <p>Offrir un cadeau qui a du sens montre à votre moitié que vous la connaissez profondément. Ce n’est pas la valeur qui compte, mais l’intention.</p>
      </div>

      <div class="romantisme-item">
        <h3>🗓️ Moments planifiés</h3>
        <p>Prévoir du temps à deux, sans distractions, renforce l’intimité du couple. Même un simple café en tête-à-tête peut faire la différence.</p>
      </div>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="rdv_coaching.php" class="btn-romantisme">Je veux des conseils personnalisés 💘</a>
    </div>
  </div>
</section>



<section id="coeurs"> 
    <div class="hero-coeurs">
    <div class="overlay-coeurs">
        <h2>Cœurs brisés</h2>
        <p>BBLove est aussi là pour vous accompagner dans les moments douloureux de la vie sentimentale.</p>
    </div>
    </div>

     <div class="points-coeurs">
      <div class="coeur-item">
        <h3>😢 Comprendre sa douleur</h3>
        <p>Un cœur brisé n'est pas juste une image : c’est un choc émotionnel. Reconnaître sa souffrance est la première étape de la guérison.</p>
      </div>

      <div class="coeur-item">
        <h3>💬 Exprimer ses émotions</h3>
        <p>Parler à quelqu’un, écrire ses ressentis ou simplement pleurer sont des formes saines d’expression. Le silence ne guérit pas toujours.</p>
      </div>

      <div class="coeur-item">
        <h3>🌱 Recommencer doucement</h3>
        <p>Il ne s’agit pas d’oublier, mais de se reconstruire. Faites des pas lents mais sûrs vers un nouveau départ, en respectant votre rythme.</p>
      </div>

      <div class="coeur-item">
        <h3>🧑‍🤝‍🧑 Se faire aider</h3>
        <p>Nos coachs sont là pour vous écouter, sans jugement. Un accompagnement humain et bienveillant pour vous aider à vous relever.</p>
      </div>
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <a href="search_coach.php" class="btn-coeurs">Contacter un coach</a>
    </div>
  </div>
</section>


<section id="histoire"> 
    <div class="hero-histoire">
        <div class="overlay-histoire">
            <h2>Histoires d'amour</h2>
            <p>Lisez des témoignages touchants de membres qui ont trouvé l'amour grâce à BBLove.</p>
        </div>
    </div>

    <div class="histoire-grid">
      <div class="histoire-card">
        <img src="images/avatars2.avif" alt="Couple 1" />
        <h3>Emma & Lucas</h3>
        <p>"On venait tous les deux de vivre une rupture difficile. Grâce à BBLove, nous nous sommes trouvés... et aujourd’hui, nous construisons une vie à deux."</p>
      </div>

      <div class="histoire-card">
        <img src="images/avatars5.avif" alt="Couple 2" />
        <h3>Sophie & Malik</h3>
        <p>"Nous étions à des kilomètres l’un de l’autre, mais le cœur n’a pas de frontières. BBLove a été le pont entre deux âmes sœurs."</p>
      </div>

      <div class="histoire-card">
        <img src="images/avatars3.avif" alt="Couple 3" />
        <h3>Julie & Karim</h3>
        <p>"On cherchait simplement à discuter… Aujourd’hui, on ne s’imagine plus l’un sans l’autre. Merci à toute l’équipe ❤️"</p>
      </div>
    </div>
</section>

<script>
    function showSection(id) {
        document.querySelectorAll('section').forEach(sec => sec.classList.remove('active'));
        document.getElementById(id).classList.add('active');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php include 'foooter.php'; ?>
