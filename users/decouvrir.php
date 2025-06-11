<?php
session_start();
include '../db.php';

// Vérification de session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];


// Récupération des informations de l'utilisateur connecté avec son profil
$stmt = $pdo->prepare("
    SELECT u.*, p.* 
    FROM users u 
     LEFT JOIN profils p ON u.id = p.user_id 
    WHERE u.id = ?
");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();

// var_dump($currentUser);

// Récupération de tous les utilisateurs avec leurs profils
$stmt = $pdo->prepare("
    SELECT u.*, p.* 
    FROM users u
    LEFT JOIN profils p ON u.id = p.user_id 
    ORDER BY u.id
");
$stmt->execute();
$allUsers = $stmt->fetchAll();
// var_dump($allUsers);

// Récupération de tous les posts avec les informations des utilisateurs
$stmt = $pdo->prepare("
    SELECT p.*, u.nom, pr.photo, pr.age, pr.ville
    FROM posts p
    JOIN users u ON p.user_id = u.id
    LEFT JOIN profils pr ON u.id = pr.user_id
    ORDER BY p.created_at DESC
");
$stmt->execute();
$allPosts = $stmt->fetchAll();


// Mise à jour de la dernière activité
$stmt = $pdo->prepare("UPDATE users SET last_activity = NOW() WHERE id = ?");
$stmt->execute([$userId]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove - Application Mobile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Styles pour la section des utilisateurs */
        .users-section {
            padding: 16px;
            background-color: var(--white);
            flex: 1;
            overflow-y: auto;
        }

        .section-title {
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 16px;
            padding-left: 8px;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }

        .user-card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .user-card:hover {
            transform: translateY(-2px);
        }

        .user-card-header {
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-card-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .user-card-info {
            flex: 1;
        }

        .user-card-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .user-card-age {
            font-size: 0.9rem;
            color: var(--dark-gray);
            margin-bottom: 2px;
        }

        .user-card-location {
            font-size: 0.9rem;
            color: var(--dark-gray);
        }

        .user-card-actions {
            display: flex;
            padding: 12px;
            gap: 8px;
            border-top: 1px solid var(--gray);
        }

        .user-card-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px;
            border-radius: 8px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .view-btn {
            background-color: var(--light);
            color: var(--dark);
        }

        .view-btn:hover {
            background-color: var(--gray);
        }

        .chat-btn {
            background-color: var(--primary);
            color: var(--white);
        }

        .chat-btn:hover {
            background-color: var(--secondary);
        }

        @media (max-width: 500px) {
            .users-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
     <!-- Barre de navigation supérieure -->
    <!-- Header -->
    <div class="header">
        <div class="logo">
        <a href="./../dashboard.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <i class="fas fa-heart"></i>
            <span>BBLove</span>
        </div>
        <div class="header-icons">
            <i class="fas fa-comment-dots header-icon"></i>
        </div>
    </div>

    <!-- Section des utilisateurs -->
    <div class="users-section">
        <h2 class="section-title">Découvrir des personnes</h2>
        <div class="users-grid">
            <?php foreach($allUsers as $user): ?>
                <?php if($user['id'] != $userId): ?>
                <div class="user-card">
                    <div class="user-card-header">
                        <img src="<?= !empty($user['photo']) ? $user['photo'] : 'https://randomuser.me/api/portraits/men/1.jpg' ?>" 
                             alt="Profil" 
                             class="user-card-avatar">
                        <div class="user-card-info">
                            <h3 class="user-card-name"><?= htmlspecialchars($user['nom']) ?></h3>
                            <p class="user-card-age"><?= htmlspecialchars($user['age'] ?? '') ?> ans</p>
                            <p class="user-card-location"><?= htmlspecialchars($user['ville'] ?? '') ?></p>
                        </div>
                    </div>
                    <div class="user-card-actions">
                        <a href="new_profil.php?user_id=<?= $user[0] ?>" class="user-card-btn view-btn">
                            <i class="fas fa-user"></i>
                            <span>Voir profil</span>
                        </a>
                        <a href="chat.php?user_id=<?= $user[0] ?>" class="user-card-btn chat-btn">
                            <i class="fas fa-comment-dots"></i>
                            <span>Discuter</span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Floating Action Button -->
    <a href="posts.php">
        <div class="fab">
            <i class="fas fa-plus"></i>
        </div>
    </a>

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
        <a href="new_profil.php?user_id=<?= htmlspecialchars($userId) ?>" class="nav-item">
          <i class="fas fa-user"></i>
          <span>Profil</span>
        </a>
    </div>

    <script>
        // Like functionality
        document.querySelectorAll('.post-action').forEach(action => {
            action.addEventListener('click', function() {
                if (this.querySelector('.fa-heart')) {
                    const icon = this.querySelector('.fa-heart, .far.fa-heart');
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.classList.add('post-liked');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.classList.remove('post-liked');
                    }
                }
            });
        });
        
        // // Bottom navigation active state
        // document.querySelectorAll('.nav-item').forEach(item => {
        //     item.addEventListener('click', function(e) {
        //         e.preventDefault();
        //         document.querySelectorAll('.nav-item').forEach(i => {
        //             i.classList.remove('active');
        //         });
        //         this.classList.add('active');
        //     });
        // });
        
        // FAB click
        document.querySelector('.fab').addEventListener('click', function() {
            alert('Créer un nouveau post ou une nouvelle rencontre');
        });
        
        // Simulate loading more posts when scrolling
        window.addEventListener('scroll', function() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100) {
                // In a real app, you would load more content here
                console.log('Load more posts...');
            }
        });
    </script>
</body>
</html>
