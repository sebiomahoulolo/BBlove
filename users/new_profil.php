<?php
session_start();
include '../db.php';

// Vérification de session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

$getUserId = $_GET['user_id'];

// var_dump($getUserId,$userId);


// Récupération des informations de l'utilisateur connecté avec son profil
$stmt = $pdo->prepare("
    SELECT u.*, p.* 
    FROM users u 
     LEFT JOIN profils p ON u.id = p.user_id 
    WHERE u.id = ?
");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();

$getUser = $pdo->prepare("
    SELECT u.*, p.* 
    FROM users u 
     LEFT JOIN profils p ON u.id = p.user_id 
    WHERE u.id = ?
");
$getUser->execute([$getUserId]);
$getUser = $getUser->fetch();

// var_dump($getUser);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove - Application Mobile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
        :root {
            --primary: #ff2d55;
            --secondary: #ff7b8b;
            --dark: #1e1e1e;
            --light: #f5f5f5;
            --white: #ffffff;
            --gray: #e4e6eb;
            --dark-gray: #b0b3b8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            height: 100vh;
            display: flex;
            flex-direction: column;
            max-width: 500px;
            margin: 0 auto;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        /* Header */
        .header {
            background-color: var(--white);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--gray);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 8px;
        }
        
        .header-icons {
            display: flex;
            gap: 15px;
        }
        
        .header-icon {
            font-size: 1.2rem;
            color: var(--dark);
        }
        
        /* Stories */
        .stories {
            background-color: var(--white);
            padding: 15px 10px;
            border-bottom: 1px solid var(--gray);
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: none;
        }
        
        .stories::-webkit-scrollbar {
            display: none;
        }
        
        .story {
            display: inline-block;
            width: 80px;
            text-align: center;
            margin-right: 10px;
            position: relative;
        }
        
        .story-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            padding: 2px;
            background-color: var(--white);
        }
        
        .story-add {
            position: absolute;
            bottom: 0;
            right: 10px;
            background-color: var(--primary);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            border: 2px solid var(--white);
        }
        
        .story-username {
            font-size: 0.7rem;
            margin-top: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Posts */
        .posts {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 60px;
        }
        
        .post {
            background-color: var(--white);
            margin-bottom: 10px;
            border-bottom: 1px solid var(--gray);
            padding: 15px;
        }
        
        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .post-user {
            display: flex;
            align-items: center;
        }
        
        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .post-info h4 {
            font-size: 0.9rem;
        }
        
        .post-info p {
            font-size: 0.7rem;
            color: var(--dark-gray);
        }
        
        .post-more {
            color: var(--dark-gray);
        }
        
        .post-content {
            margin-bottom: 10px;
        }
        
        .post-image {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        
        .post-actions {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--gray);
            border-bottom: 1px solid var(--gray);
            padding: 8px 0;
            margin-bottom: 10px;
        }
        
        .post-action {
            display: flex;
            align-items: center;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        .post-action i {
            margin-right: 5px;
        }
        
        .post-liked {
            color: var(--primary);
        }
        
        .post-comments {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }
        
        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: 500px;
            background-color: var(--white);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 1px solid var(--gray);
            z-index: 100;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--dark-gray);
            text-decoration: none;
            font-size: 0.7rem;
        }
        
        .nav-item i {
            font-size: 1.3rem;
            margin-bottom: 3px;
        }
        
        .nav-item.active {
            color: var(--primary);
        }
        
        .nav-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--primary);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
        }
        
        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 70px;
            right: 20px;
            background-color: var(--primary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            z-index: 90;
        }
        
        /* Responsive */
        @media (max-width: 500px) {
            body {
                height: 100vh;
                max-width: 100%;
            }
        }
    </style>
    <style>
        /* Styles spécifiques à la page de profil */

   

      .profile-header-title {
                font-weight: 600;
                color: var(--dark-color);
            }

            .back-button {
                color: var(--dark-color);
                font-size: 18px;
            }

            /* Bannière de profil */
            .profile-banner {
                position: relative;
                height: 200px;
                overflow: hidden;
            }

            .banner-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .profile-picture-container {
                position: absolute;
                bottom: -50px;
                left: 20px;
            }

            .profile-picture {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                border: 4px solid white;
                object-fit: cover;
            }

            .edit-profile-btn {
                position: absolute;
                bottom: 5px;
                right: 5px;
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background-color: var(--primary-color);
                color: white;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            /* Informations utilisateur */
            .profile-info {
                margin-top: 60px;
                padding: 15px;
                background-color: white;
            }

            .profile-info h1 {
                font-size: 24px;
                margin-bottom: 5px;
            }

            .profile-bio {
                color: #65676B;
                margin-bottom: 15px;
            }

            .profile-details {
                margin-bottom: 15px;
            }

            .profile-details p {
                margin-bottom: 5px;
                color: #65676B;
                font-size: 14px;
            }

            .profile-details i {
                width: 20px;
                text-align: center;
                margin-right: 5px;
                color: var(--primary-color);
            }

            .profile-actions {
                display: flex;
                gap: 10px;
                margin-top: 15px;
            }

            .primary-btn, .secondary-btn, .icon-btn {
                padding: 8px 15px;
                border-radius: 6px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 5px;
                cursor: pointer;
            }

            .primary-btn {
                background-color: var(--primary-color);
                color: white;
                border: none;
                flex: 1;
                justify-content: center;
            }

            .secondary-btn {
                background-color: #E4E6EB;
                color: var(--dark-color);
                border: none;
                flex: 1;
                justify-content: center;
            }

            .icon-btn {
                background-color: #E4E6EB;
                color: var(--dark-color);
                border: none;
                width: 40px;
                justify-content: center;
            }

            /* Navigation du profil */
            .profile-nav {
                display: flex;
                background-color: white;
                margin-top: 10px;
                border-bottom: 1px solid var(--gray-color);
            }

            .profile-nav a {
                flex: 1;
                text-align: center;
                padding: 15px 0;
                color: #65676B;
                text-decoration: none;
                font-weight: 500;
                position: relative;
            }

            .profile-nav a.active {
                color: var(--primary-color);
            }

            .profile-nav a.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 25%;
                right: 25%;
                height: 3px;
                background-color: var(--primary-color);
                border-radius: 3px;
            }

            /* Contenu du profil */
            .profile-content {
                padding-bottom: 70px;
            }

            /* Sections */
            .about-section, .photos-section, .friends-section, .profile-posts {
                background-color: white;
                margin-top: 10px;
                padding: 15px;
            }

            .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .section-header h2 {
                font-size: 18px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .section-header h2 i {
                color: var(--primary-color);
            }

            .section-header h2 span {
                font-weight: normal;
                color: #65676B;
                font-size: 14px;
            }

            .section-header a {
                color: var(--primary-color);
                font-size: 14px;
                text-decoration: none;
            }

            /* Section À propos */
            .about-item {
                margin-bottom: 15px;
            }

            .about-item h3 {
                font-size: 15px;
                margin-bottom: 5px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .about-item h3 i {
                color: var(--primary-color);
                width: 20px;
                text-align: center;
            }

            .about-item p {
                color: #65676B;
                font-size: 14px;
                margin-left: 28px;
            }

            /* Section Photos */
            .photos-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 5px;
            }

            .photos-grid img {
                width: 100%;
                aspect-ratio: 1;
                object-fit: cover;
                border-radius: 5px;
            }

            /* Section Amis */
            .friends-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .friend-card {
                text-align: center;
            }

            .friend-card img {
                width: 100%;
                aspect-ratio: 1;
                object-fit: cover;
                border-radius: 8px;
                margin-bottom: 5px;
            }

            .friend-card p {
                font-size: 13px;
                font-weight: 500;
            }

            /* Publications du profil */
            .profile-posts .post {
                margin-top: 10px;
            }
    </style>
</head>
<body>
    <!-- Barre de navigation supérieure -->
    <header class="header">
        <a href="./../dashboard.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
        <div class="profile-header-title">Profil</div>
        <!-- <div class="header-icons">
            <i class="fas fa-search"></i>
            <i class="fas fa-ellipsis-h"></i>
        </div> -->
    </header>

    <!-- Bannière de profil -->
    <div class="profile-banner">
        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Bannière" class="banner-image">
        <div class="profile-picture-container">
            <img src="<?= !empty($getUser['photo']) ? $getUser['photo'] : 'https://randomuser.me/api/portraits/women/44.jpg' ?>" alt="Profil" class="profile-picture">
            <?php if($userId == $getUserId): ?>
            <button class="edit-profile-btn"><i class="fas fa-camera"></i></button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Informations utilisateur -->
    <div class="profile-info">
        <h1><?= htmlspecialchars($getUser['nom']) ?></h1>
        <p class="profile-bio"><?= htmlspecialchars($getUser['description'] ?? 'Nouveau sur BBLove !') ?></p>
        <div class="profile-details">
            <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($getUser['ville'] ?? 'Non spécifié') ?></p>
            <p><i class="fas fa-heart"></i> <?= htmlspecialchars($getUser['situation_amoureuse'] ?? 'Non spécifié') ?></p>
            <p><i class="fas fa-user-friends"></i> <?= htmlspecialchars($getUser['age'] ?? '') ?> ans</p>
        </div>
        <div class="profile-actions">
            <?php if($userId !== $getUserId): ?>
                <button class="primary-btn"><i class="fas fa-user-plus"></i> Ajouter</button>
            <button class="secondary-btn"><i class="fas fa-comment-dots"></i> <a href="chat.php?user_id=<?= $getUserId ?>" style="text-decoration: none; color: var(--dark-color);">Message</a> </button>
            <button class="icon-btn"><i class="fas fa-ellipsis-h"></i></button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation du profil -->
    <!-- <nav class="profile-nav">
        <a href="#" class="active">Publications</a>
        <a href="#">Photos</a>
        <a href="#">Amis</a>
        <a href="#">Infos</a>
    </nav> -->

    <!-- Contenu du profil -->
    <div class="profile-content">
        <!-- Section À propos -->
        <div class="about-section">
            <h2><i class="fas fa-info-circle"></i> À propos</h2>
            <div class="about-item">
                <h3><i class="fas fa-briefcase"></i> Profession</h3>
                <p><?= htmlspecialchars($getUser['metier'] ?? 'Non spécifié') ?></p>
            </div>
            <div class="about-item">
                <h3><i class="fas fa-heart"></i> Situation amoureuse</h3>
                <p><?= htmlspecialchars($getUser['situation_amoureuse'] ?? 'Non spécifié') ?></p>
            </div>
            <div class="about-item">
                <h3><i class="fas fa-home"></i> Ville</h3>
                <p><?= htmlspecialchars($getUser['ville'] ?? 'Non spécifié') ?></p>
            </div>
            <div class="about-item">
                <h3><i class="fas fa-calendar-alt"></i> Âge</h3>
                <p><?= htmlspecialchars($getUser['age'] ?? '') ?> ans</p>
            </div>
            <div class="about-item">
                <h3><i class="fas fa-smoking"></i> Fumeur</h3>
                <p><?= htmlspecialchars($getUser['fumeur'] ?? 'Non spécifié') ?></p>
            </div>
            <div class="about-item">
                <h3><i class="fas fa-glass-martini-alt"></i> Alcool</h3>
                <p><?= htmlspecialchars($getUser['alcool'] ?? 'Non spécifié') ?></p>
            </div>
            <div class="row">
                <button class="btn btn-sm btn-danger py-2" onclick="window.location.href='../logout.php'"> <i class="fas fa-sign-out-alt"></i> Se déconnecter</button>
            </div>
        </div>

        <!-- Section Photos -->
        <div class="photos-section">
            <div class="section-header">
                <h2><i class="fas fa-images"></i> Photos</h2>
                <a href="#">Voir tout</a>
            </div>
            <div class="photos-grid">
                <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Photo 1">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Photo 2">
                <img src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Photo 3">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Photo 4">
                <img src="https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Photo 5">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Photo 6">
            </div>
        </div>

      

      
    </div>

     <!-- Bottom Navigation -->
     <div class="bottom-nav">
        <a href="./../dashboard.php" class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="decouvrir.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Découvrir</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-bars"></i>
            <span>Rencontres</span>
        </a>
        <a href="recuperer_user.php" class="nav-item">
            <i class="fas fa-comment-dots"></i>
            <span>Messages</span>
            <!-- <div class="nav-notification">3</div> -->
        </a>
        <a href="./new_profil.php?user_id=<?=$userId ?>" class="nav-item">
          <i class="fas fa-user"></i>
          <span>Profil</span>
        </a>
    </div>



    <script src="profile.js"></script>
</body>
</html>
