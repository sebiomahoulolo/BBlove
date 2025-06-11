<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>BBLove - Rencontrez l'Amour</title>

    <!-- Polices d'écriture -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS de Swiper.js -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <style>
        :root {
            --primary-color: #ff6b9d;
            --secondary-color: #ff9a9e;
            --text-color: #333;
            --background-color: #fff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #fecfef 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--text-color);
        }

        .app-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Header Styles */
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        /* .logo {
            font-family: 'Parisienne', cursive;
            font-size: 2.5rem;
            color: var(--primary-color);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .logo span {
            display: inline-block;
            animation: float 3s ease-in-out infinite;
            animation-delay: calc(0.1s * var(--i));
        } */

        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 2rem 0;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .card:active {
            transform: scale(0.95);
        }

        .card-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        /* Carousel Sections */
        .carousel-section {
            margin: 2rem 0;
        }

        .carousel-section h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .swiper {
            width: 100%;
            padding: 1rem 0;
        }

        .profile-slide {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .profile-slide img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .profile-info {
            padding: 1rem;
        }

        .event-slide {
            height: 200px;
            background-size: cover;
            background-position: center;
            border-radius: 15px;
            position: relative;
        }

        .event-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            color: white;
            border-radius: 0 0 15px 15px;
        }
.header-icon {
    font-size: 1.5rem;
    color: #333;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
}

.header-icon:hover {
    transform: scale(1.2);
    color: #FF5A5F;
}

        .testimony-slide {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .quote {
            font-style: italic;
            margin-bottom: 1rem;
        }

        .author {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Media Queries */
        @media (min-width: 768px) {
            .app-container {
                display: none;
            }
            
            body::after {
                content: "Cette application est uniquement disponible sur mobile";
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                font-size: 1.5rem;
                text-align: center;
                padding: 2rem;
                background: white;
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
        }
    </style>
</head>
<body>
   <!-- Header -->
    <div class="header">
    <div class="logo">
        <i class="fas fa-heart"></i>
        <span>BBLove</span>
    </div>
    <div class="header-icons">
       
        <i class="fas fa-circle-question header-icon"></i>
    </div>
</div>
<br><br>
<style>
    .header {
    background-color: #ffffff; /* Fond blanc */
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

.logo {
    display: flex;
    align-items: center;
    font-size: 1.5rem;
    font-weight: bold;
    color: #FF5A5F;
}

.logo i {
    font-size: 1.8rem;
    margin-right: 8px;
}

.header-icons {
    display: flex;
    gap: 15px;
}

.header-icon {
    font-size: 1.5rem;
    color: #333;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
}

.header-icon:hover {
    transform: scale(1.2);
    color: #FF5A5F;
}

</style>

        <main>
 <section class="services-grid">
    <div class="heart-container"></div>

    <div class="card">

        <a href="login.php" class="btn-custom">
            <div class="card-icon"><i class="fa-solid fa-search"></i></div>
            <h3>Recherche</h3>
        </a>
    </div>
    <div class="card">
        <a href="login.php" class="btn-custom">
            <div class="card-icon"><i class="fa-solid fa-chalkboard-teacher"></i></div>
            <h3>Coaching</h3>
        </a>
    </div>
    <div class="card">
        <a href="even.php" class="btn-custom">
            <div class="card-icon"><i class="fa-solid fa-calendar"></i></div>
            <h3>Évènements</h3>
        </a>
    </div>
    <div class="card">
        <a href="login.php" class="btn-custom">
            <div class="card-icon"><i class="fa-solid fa-gift"></i></div>
            <h3>Surprise</h3>
        </a>
    </div>
    <style>
        .services-grid {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.card {
    background: linear-gradient(145deg, #ffffff,rgb(241, 163, 163));
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    animation: heartbeat 1.5s infinite ease-in-out;
}

@keyframes heartbeat {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.card-icon {
    font-size: 2rem;
    color: #ff6b9d;
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2);
    animation: rotate-jump 30s infinite ease-in-out;
}

@keyframes rotate-jump {
    0% { transform: rotate(0deg) translateY(0); }
    50% { transform: rotate(360deg) translateY(-10px); }
    100% { transform: rotate(0deg) translateY(0); }
}

.btn-custom {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    display: block;
}
.heart-container {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

@keyframes float-heart {
    0% { transform: translateY(0) scale(1); opacity: 1; }
    100% { transform: translateY(-100vh) scale(1.5); opacity: 0; }
}

.heart-container::before, 
.heart-container::after {
    content: "❤️";
    position: absolute;
    font-size: 2rem;
    color: rgba(255, 107, 157, 0.8);
    animation: float-heart 5s infinite ease-in-out;
}

.heart-container::before {
    left: 20%;
    animation-duration: 4s;
    animation-delay: 1s;
}

.heart-container::after {
    right: 30%;
    animation-duration: 6s;
    animation-delay: 2s;
}
.event-info a {
    text-decoration: none; /* Supprime le soulignement */
    color: inherit; /* Garde la couleur du texte par défaut */
}



    </style>
</section>



            <section class="carousel-section">
                <h2>Ils vous attendent...</h2>
                <div class="swiper profile-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide profile-slide">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&q=80&fm=jpg&crop=faces&fit=crop&h=400&w=400" alt="Profil de Léa">
                            <div class="profile-info">
                                <h3>Léa, 28 ans</h3>
                                <p>Passionnée d'art et de voyages</p>
                                     <a href="login.php" class=" btn-custom"  style="color:rgb(84, 159, 246);" >Voir profil</a>
                        
                            </div>
                       </div>
                        <div class="swiper-slide profile-slide">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&q=80&fm=jpg&crop=faces&fit=crop&h=400&w=400" alt="Profil de Marc">
                            <div class="profile-info">
                                <h3>Marc, 31 ans</h3>
                                <p>Aventurier au grand cœur</p>
                                     <a href="login.php" class=" btn-custom" style="color:rgb(84, 159, 246);">Voir profil</a>
                        
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="carousel-section">
                <h2>Nos prochains évènements</h2>
                <div class="swiper event-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide event-slide" style="background-image: url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&q=80&fm=jpg&w=1080');">
                            <div class="event-info"><a href="even.php">
                                <h3>Soirée "Starlight Dating"</h3>
                                <p>Samedi 20 Avril - Rooftop Le Ciel</p></a>
                            </div>
                        </div>
                        <div class="swiper-slide event-slide" style="background-image: url('https://images.unsplash.com/photo-1556742521-9713c26012b3?ixlib=rb-4.0.3&q=80&fm=jpg&w=1080');">
                            <div class="event-info">
                                <h3>Atelier Cocktail Romantique</h3>
                                <p>Vendredi 26 Avril - Le Speakeasy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="carousel-section">
                <h2>Ils se sont trouvés</h2>
                <div class="swiper testimony-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide testimony-slide">
                            <p class="quote">"Je n'y croyais plus, et pourtant... J'ai rencontré l'homme de ma vie grâce à BBLove. C'était magique !"</p>
                            <p class="author">- Marie & Julien</p>
                        </div>
                        <div class="swiper-slide testimony-slide">
                            <p class="quote">"Une app sérieuse, des profils de qualité et un évènement qui a tout changé. Merci !"</p>
                            <p class="author">- Sophie</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

<div class="separator"></div>

<section class="profiles-section">
  <h2 style="text-align:center; color: #FF5A5F; font-size: 2rem; font-weight: bold;">
    Explorez des profils compatibles
  </h2>

  <div class="profiles-carousel swiper">
    <div class="swiper-wrapper">
      <!-- Profil 1 -->
      <div class="swiper-slide profile-card">
        <img src="img/avatar1.avif" alt="Profil de Sophie" class="profile-image">
        <div class="profile-name">Sophie, 29 ans</div>
        <div class="profile-bio">Recherche une relation sincère et stable, basée sur la communication.</div>
        <?php
if (isset($_SESSION['user_id'])) {
    echo '<button class="profile-btn"><a href="users/voir_profil.php">Voir le profil</a></button>';
} else {
    echo '<button class="profile-btn"><a href="login.php">Connectez-vous pour voir les profils</a></button>';
}
?> </div>

      <!-- Profil 2 -->
      <div class="swiper-slide profile-card">
        <img src="img/avatar2.avif" alt="Profil de Alex" class="profile-image">
        <div class="profile-name">Alex, 32 ans</div>
        <div class="profile-bio">Souhaite trouver une âme sœur passionnée par les voyages et la culture.</div>
     <?php
if (isset($_SESSION['user_id'])) {
    echo '<button class="profile-btn"><a href="users/voir_profil.php">Voir le profil</a></button>';
} else {
    echo '<button class="profile-btn"><a href="login.php">Connectez-vous pour voir les profils</a></button>';
}
?>
 </div>

      <!-- Profil 3 -->
      <div class="swiper-slide profile-card">
        <img src="img/avatar3.avif" alt="Profil de Jade" class="profile-image">
        <div class="profile-name">Jade, 26 ans</div>
        <div class="profile-bio">Cherche quelqu’un de drôle et attentionné pour construire quelque chose de vrai.</div>
       <?php
if (isset($_SESSION['user_id'])) {
    echo '<button class="profile-btn"><a href="users/voir_profil.php">Voir le profil</a></button>';
} else {
    echo '<button class="profile-btn"><a href="login.php">Connectez-vous pour voir les profils</a></button>';
}
?> </div>
    </div>

    <!-- Boutons de navigation -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>
</section>

  <style>
/* Carousel */
.profiles-carousel {
    width: 90%;
    margin: auto;
    overflow: hidden;
}

/* Cartes de profil */
.profile-card {
    background: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.profile-card:hover {
    transform: scale(1.05);
}

/* Image de profil */
.profile-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #FF5A5F;
}

/* Nom du profil */
.profile-name {
    font-size: 1.4rem;
    font-weight: bold;
    color: #FF5A5F;
    margin-top: 10px;
}

/* Bio du profil */
.profile-bio {
    font-size: 1rem;
    color: #333;
    margin-top: 8px;
    padding: 10px;
    background: #fff;
    border-radius: 10px;
}

/* Bouton "Voir le profil" */
.profile-btn {
    background-color: #FF5A5F;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    display: block;
    margin: 15px auto;
}

.profile-btn a {
    text-decoration: none;
    color: white;
}

.profile-btn:hover {
    background-color: #e0484d;
}

  </style>
  
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".profiles-carousel", {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        loop: true,
        autoplay: {
            delay: 3000
        },
        breakpoints: {
            600: { slidesPerView: 2 },
            900: { slidesPerView: 3 }
        }
    });
</script>

    <!-- Scripts -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // Initialisation des Swipers
        const swiperConfig = {
            slidesPerView: 1.2,
            spaceBetween: 15,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        };

        new Swiper('.profile-swiper', swiperConfig);
        new Swiper('.event-swiper', swiperConfig);
        new Swiper('.testimony-swiper', swiperConfig);

        // Animation du logo
       // document.querySelectorAll('.logo span').forEach((span, index) => {
         //   span.style.setProperty('--i', index + 1);
      //  });

        // Optimisation des performances
        document.addEventListener('DOMContentLoaded', () => {
            // Lazy loading des images
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.loading = 'lazy';
            });
        });
    </script>
</body>
</html> 